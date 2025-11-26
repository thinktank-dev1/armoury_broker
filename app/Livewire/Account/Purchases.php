<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\Attributes\On;

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

    public function seveDispute(){
        Dispute::create([
            'user_id' => Auth::user()->id,
            'vendor_id' => $this->vendor_id,
            'order_id' => $this->item_id,
            'message' => $this->grievance,
            'status' => 0,
        ]);
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
