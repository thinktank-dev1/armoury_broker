<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\Attributes\On; 

use App\Lib\Communication;

use Auth;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\ShippingService;
use App\Models\Setting;
use App\Models\User;
use App\Models\MessageThread;
use App\Models\Dispute;

class Orders extends Component
{
    
    public $cur_item = [];
    public $action_text;

    public $orders_items_arr = [];

    public $filter;
    public $shipping_service_name;

    public $cancel_id;
    public $item_id, $vendor_id;
    public $grievance;

    public function mount(){
        $this->filter = "all_orders";

        $orders = Order::query()
        ->where('vendor_id', Auth::user()->vendor->id)
        ->orderBy('created_at', 'DESC')
        ->get();

        foreach($orders AS $ord){
            foreach($ord->items AS $itm){
                $arr = [
                    'shiping_service' => $itm->shiping_service,
                    'tracking_number' => $itm->tracking_number,
                    'vendor_status' => $itm->vendor_status,
                ];
                $this->orders_items_arr[$itm->id] = $arr;
            }
        }
    }

    public function showDisputeModal($item_id, $vendor_id){
        $this->item_id = $item_id;
        $this->vendor_id = $vendor_id;
        $this->dispatch('show-dispute-modal');
    }

    public function seveDispute(){
        Dispute::create([
            'user_id' => Auth::user()->id,
            'vendor_id' => $this->vendor_id,
            'order_id' => $this->item_id,
            'message' => $this->grievance,
            'status' => 0,
        ]);

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

        $body = Auth::user()->vendor->name." has filed a dispute <b>(Seller)</b>.<br /><br />
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

    public function messageBuyer($id){
        $ord_itm = OrderItem::find($id);
        if($ord_itm){
            $tr = MessageThread::where('user_1', Auth::user()->id)->where('user_2', $ord_itm->user->id)->where('order_item_id', $id)->first();
            if(!$tr){
                $tr = new MessageThread();
                $tr->user_1 = Auth::user()->id;
                $tr->user_2 = $ord_itm->user->id;
                if($ord_itm->order){
                    $tr->order_id = $ord_itm->order->id;
                }
                $tr->order_item_id = $id;
                $tr->save();
            }
            return redirect('messages/'.$tr->id);
        }
    }

    public function cancelOrder(){
        $ord = OrderItem::find($this->cancel_id);
        if($ord){
            $ord->vendor_status = "Canceled";
            $ord->save();

            $trx = Transaction::where('order_item_id', $ord->id)->where('name', 'order_payment')->first();
            if($trx){
                $trx->canceled = 1;
                $trx->save();
            }

            $stn = Setting::where('name', 'service_fee')->first();

            $amount = ($stn->value / 100) * $ord->price;
            Transaction::create([
                'name' => 'canceled_order',
                'transaction_type' => 'canceled_order',
                'user_id' => Auth::user()->id,
                'vendor_id' => Auth::user()->vendor_id,
                'direction' => 'out',
                'amount' => $amount,
                'order_id' => $ord->order_id,
                'order_item_id' => $ord->id,
                'payment_status' => 'COMPLETE',
                'release' => 1,
            ]);
            $usr = User::find($ord->user_id);
            Transaction::create([
                'name' => 'refund',
                'transaction_type' => 'refund',
                'user_id' => $usr->id,
                'vendor_id' => $usr->vendor_id,
                'direction' => 'in',
                'amount' => $ord->price,
                'order_id' => $ord->order_id,
                'order_item_id' => $ord->id,
                'payment_status' => 'COMPLETE',
                'release' => 1,
            ]);
            $this->dispatch('close-modal');
        }
    } 

    public function showCancelConfirmation($id){
        $this->cancel_id = $id;
        $this->dispatch("show-cancel-confirmation");
    }

    public function updateOrderStatus($id){
        $ord = OrderItem::find($id);
        if($ord){
            $itm = $this->orders_items_arr[$id];

            $ord->shiping_service = $itm['shiping_service'];
            $ord->tracking_number = $itm['tracking_number'];
            $ord->vendor_status = $itm['vendor_status'];
            if($itm['vendor_status'] == "Order Dispatched"){
                $ord->dispatch_date = date('Y-m-d');
            }
            $ord->save();
        }
        $order = $ord->order;
        $go = True;
        foreach($order->items AS $itm){
            if(!$itm->vendor_status){
                $go = False;
                break;
            }
        }
        if($go){
            $order->shipping_status = 1;
            $order->save();

            foreach($order->items AS $item){
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
                $sold_price = ($item->total_paid - $item->shipping_price - $item->service_fee) / $item->quantity;
                                                        
                $order_data .= "<td>";
                $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
                $order_data .= "<tr><td>Order Date:</td><td>".date('Y-m-d', strtotime($item->created_at))."</td></tr>";
                $order_data .= "<tr><td>Item Name:</td><td>".$item->product->item_name."</td></tr>";
                $order_data .= "<tr><td>Quantity:</td><td>".$item->quantity."</td></tr>";
                $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($item->product->item_price,2)."</td></tr>";
                $order_data .= "<tr><td>Sold Price:</td><td>R ".number_format($sold_price,2)."</td></tr>";
                $order_data .= "<tr><td>Discount Applied:</td><td>".$item->discount."</td></tr>";
                $order_data .= "<tr><td>Delivery Type:</td><td>".ucwords(str_replace('_', ' ',$item->shipping_method))."</td></tr>";
                $order_data .= "</table>";
                $order_data .= "</td>";
                $order_data .= "</tr>";
                $order_data .= "</table>";
            }

            $dl_user = $item->user;

            $body = "Hi ".$item->user->vendor->name."</b><br /><br />
            Great news!<br />
            Your order ".str_pad($order->id, 4, '0', STR_PAD_LEFT)." has been shipped by ".$order->vendor->name.".".$order_data;
            $body .= "<strong>Next step:<strong><br />
            <p>Once the item has been received, please ensure that you update the status on the platform to “Item Received” and confirm that all is in order. </p>
            <p>Only once that has been done, we will release the funds to the seller.</p>
            <p>Congratulations on your purchase!</p>";

            $data = [
                'to' => $dl_user->email,
                'name' => $dl_user->name,
                'subject' => 'Shipping Confirmed',
                'title' => "Shipping Confirmed",
                'message_body' => $body,
                'cta' => false,
                'cta_text' => null,
                'cta_url' => null,
                'after_cta_body' => null,
            ];
            $comm = new Communication();
            $comm->sendMail($data);
        }
        $this->dispatch('order-item-edited');
    }

    public function saveShipService(){
        $this->validate([
            'shipping_service_name' => 'required'
        ]);
        ShippingService::create([
            'vendor_id' => Auth::user()->vendor_id,
            'name' => $this->shipping_service_name,
        ]);
        $this->dispatch('close-modal');
        $this->shipping_service_name = null;
    }

    public function changeFilter($f){
        $this->filter = $f;
    }

    public function render(){
        $order = [];
        if(Auth::user()->vendor){
            $filter = $this->filter;

            $orders = Order::query()
            ->where('vendor_id', Auth::user()->vendor->id)
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
            ->whereHas('items')
            ->orderBy('created_at', 'DESC')
            ->get();
        }

        $services = ShippingService::where('vendor_id', Auth::user()->vendor_id)->orderBy('name', 'ASC')->get();

        return view('livewire.account.orders', [
            'orders' => $orders,
            'services' => $services
        ]);
    }
}
