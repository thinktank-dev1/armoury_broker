<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Lib\Communication;

use Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\MessageThread;
use App\Models\Vendor;
use App\Models\Dispute;

class Purchases extends Component
{
    public $cur_item;

    public $filter;
    public $order_item;

    public $item_id, $vendor_id, $grievance;

    public function mount(){
        $this->filter = "all_orders";

        $this->show_action_btn = false;
    }

    public function changeFilter($f){
        $this->filter = $f;
    }

    public function showDisputeModal($item_id, $vendor_id){
        $this->item_id = $item_id;
        $this->vendor_id = $vendor_id;
        $this->dispatch('show-dispute-modal');
    }

    public function setDisputeResolved($id){
        $dsp = Dispute::find($id);
        if($dsp){
            if($dsp->user_1 == Auth::user()->id){
                $dsp->user_1_status = 1;
            }
            if($dsp->user_2 == Auth::user()->id){
                $dsp->user_2_status = 1;
            }
            $dsp->save();
        }
    }

    public function seveDispute(){
        $item = OrderItem::find($this->item_id);
        $user_1 = Auth::user()->id;
        $user_2 = $item->user_id;
        $dsp = Dispute::where('order_id', $item->order_id)->where('item_id', $item->id)->first();
        if(!$dsp){
            $dsp = new Dispute();
        }
        
        $dsp->user_1 = $user_1;
        $dsp->user_2 = $user_2;
        $dsp->order_id = $item->order_id;
        $dsp->item_id = $item->id;
        $dsp->message = $this->grievance;
        $dsp->user_1_status = 0;
        $dsp->user_2_status = 0;
        $dsp->save();

        $item = OrderItem::find($this->item_id);
        $order = $item->order;

        $to = env('ADMIN_EMAIL', 'wilson@thinktank.co.za');
        $comm = new Communication();

        $order_data = "<table class='table-bodered' style='width: 100%'>";
        $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</th></tr></thead>";
        $order_data .= "<tbody>";
        
        $order_data .= "<tr>";
        if($item->product->images->count() > 0){
            $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$item->product->images->first()->image_url)."'></td>";
        }
        else{
            $order_data .= "<td></td>";
        }
        $order_data .= "<td>";
        $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
        $order_data .= "<tr><td>Order Date:</td><td>".date('Y-m-d', strtotime($item->created_at))."</td></tr>";
        $order_data .= "<tr><td>Item Name:</td><td>".$item->product->item_name."</td></tr>";
        $order_data .= "<tr><td>Quantity:</td><td>".$item->quantity."</td></tr>";
        $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($item->product->item_price,2)."</td></tr>";
        $order_data .= "<tr><td>Sold Price:</td><td>R ".number_format($item->price,2)."</td></tr>";
        $order_data .= "<tr><td>Discount Applied:</td><td>".$item->discount."</td></tr>";
        $order_data .= "<tr><td>Delivery Type:</td><td>".ucwords(str_replace('_', ' ',$item->shipping_method))."</td></tr>";
        $order_data .= "</table>";
        $order_data .= "</td>";
        $order_data .= "</tr>";
        
        $order_data .= "</table>";

        $body = Auth::user()->vendor->name." has filed a dispute <b>(Buyer)</b>.<br /><br />
        <b>Dispute Message:</b><br />
        ".$this->grievance."<br /><br />
        <b>Product Details:</b>
        ".$order_data;

        $data = [
            'to' => $to,
            'name' => 'Armoury Broker',
            'subject' => 'Armoury Broker Order dispute',
            'title' => "Order dispute",
            'message_body' => $body,
            'cta' => false,
            'cta_text' => null,
            'cta_url' => null,
            'after_cta_body' => null,
        ];
        
        $comm = new Communication();
        $comm->sendMail($data);

        $this->dispatch('close-modal');
        $this->dispatch('dispute-saved');
    }

    public function messageSeller($id){
        $ord_itm = OrderItem::find($id);
        if($ord_itm){
            $vnd = $ord_itm->vendor->user;
            $tr = MessageThread::where('user_1', $vnd->id)->where('user_2', Auth::user()->id)->where('order_item_id', $id)->first();
            if(!$tr){
                $tr = new MessageThread();
                $tr->user_1 = $vnd->id;
                $tr->user_2 = Auth::user()->id;
                if($ord_itm->order){
                    $tr->order_id = $ord_itm->order->id;
                }
                $tr->order_item_id = $id;
                $tr->save();
            }
            return redirect('messages/'.$tr->id);
        }
    }

    public function showReceiptConfirmation($id){
        $this->order_item = $id;
        $this->dispatch('show-confirm-receipt');
    }

    public function confirmedReceipt(){
        $ord = OrderItem::find($this->order_item);
        if($ord){
            $ord->buyer_status = "Received";
            $ord->receipt_date = date('Y-m-d');
            $ord->save();
            $trx = Transaction::where('order_item_id', $ord->id)->where('name', 'order_payment')->first();
            if($trx){
                $trx->release = 1;
                $trx->save();
            }
        }
        $this->order_item = null;
        $this->dispatch('close-modal');
    }

    public function markOrderShipped($id){
        $ord = OrderItem::find($id);
        if($ord){
            $ord->buyer_status = 'Complete';
            $ord->save();

            if($ord->vendor_status == 'Complete' && $ord->buyer_status == "Complete"){
                $trx = Transaction::where('order_item_id', $ord->id)->first();
                if($trx){
                    $trx->release = 1;
                    $trx->save();
                }
            }
        }
        $this->dispatch('close-modal');
    }

    public function render(){
        $filter = $this->filter;

        $orders = Order::query()
        ->where('user_id', Auth::user()->id)
        ->when($filter, function($q) use($filter){
            if($filter == "complete"){
                return $q->whereHas('items', function($qq){
                    return $qq->where('vendor_status', "Order Dispatched")->where('buyer_status', 'Received');
                });
            }
            elseif($filter == "pending_payement"){
                return $q->where('g_payment_id', null);
            }
            elseif($filter == "pending_dispatch"){
                return $q->whereHas('items', function($qq){
                    return $qq->whereNull('vendor_status');
                });
            }
            elseif($filter == "dispatched"){
                return $q->whereHas('items', function($qq){
                    return $qq->where('vendor_status', 'Order Dispatched');
                });
            }
        })
        ->orderBy('created_at', 'DESC')
        ->get();

        return view('livewire.account.purchases', [
            'orders' => $orders
        ]);
    }
}
