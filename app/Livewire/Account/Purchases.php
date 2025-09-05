<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;

class Purchases extends Component
{
    public $cur_item;
    public $action_text, $show_action_btn;

    public function mount(){
        $this->show_action_btn = false;
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

    public function showItemDetailsModal($id){
        $this->show_action_btn = false;

        $itm = OrderItem::find($id);
        if($itm){
            $this->cur_item = $itm;

            if($itm->deliver_collection == "Courier"){
                if($itm->vendor_status && !$itm->buyer_status){
                    $this->action_text = "Item Received";
                    $this->show_action_btn = True;
                }
            }
            elseif($itm->deliver_collection == "collection"){
                if(!$itm->buyer_status){
                    $this->action_text = "Collected";
                    $this->show_action_btn = True;
                }
            }
            elseif($itm->deliver_collection == "seller delivery"){
                if(!$itm->buyer_status){
                    $this->action_text = "Item Received";
                    $this->show_action_btn = True;
                }
            }
            elseif($itm->deliver_collection == "dealer stock"){
                if(!$itm->buyer_status){
                    $this->action_text = "I confirm the item is with Dealer";
                    $this->show_action_btn = True;
                }
            }

            $this->dispatch('show-item-details-modal');
        }
    }

    public function render(){
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('livewire.account.purchases', [
            'orders' => $orders
        ]);
    }
}
