<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;

class Orders extends Component
{
    
    public $cur_item = [];
    public $action_text;

    public function markOrderShipped($id){
        $ord = OrderItem::find($id);
        if($ord){
            $ord->vendor_status = 'Complete';
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

    public function showItemDetailsModal($id){
        $itm = OrderItem::find($id);
        if($itm){
            $this->cur_item = $itm;
            if($itm->deliver_collection == "Courier"){
                $this->action_text = "Shipped";
            }
            elseif($itm->deliver_collection == "collection"){
                $this->action_text = "Collected";
            }
            elseif($itm->deliver_collection == "seller delivery"){
                $this->action_text = "Delivered";
            }
            elseif($itm->deliver_collection == "dealer stock"){
                $this->action_text = "Sent to Dealer";
            }

            $this->dispatch('show-item-details-modal');
        }
    }

    public function render(){
        $order = [];
        if(Auth::user()->vendor){
            $orders = Order::query()
            ->where('vendor_id', Auth::user()->vendor->id)
            ->whereNotNull('g_payment_id')
            ->orderBy('created_at', 'DESC')
            ->get();
        }
        return view('livewire.account.orders', [
            'orders' => $orders
        ]);
    }
}
