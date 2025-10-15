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

class Purchases extends Component
{
    public $cur_item;

    public $filter;
    public $order_item;

    public function mount(){
        $this->show_action_btn = false;
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

    #[On('confirmed-receipt')]
    public function confirmedReceipt(){
        $ord = OrderItem::find($this->order_item);
        if($ord){
            $ord->buyer_status = "Received";
            $ord->save();
            $trx = Transaction::where('order_item_id', $ord->id)->first();
            if($trx){
                $trx->release = 1;
                $trx->save();
            }
        }
        $this->order_item = null;
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
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('livewire.account.purchases', [
            'orders' => $orders
        ]);
    }
}
