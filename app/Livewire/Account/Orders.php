<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\Attributes\On; 

use Auth;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\ShippingService;
use App\Models\Setting;
use App\Models\User;
use App\Models\MessageThread;

class Orders extends Component
{
    
    public $cur_item = [];
    public $action_text;

    public $orders_items_arr = [];

    public $filter;
    public $shipping_service_name;

    public $cancel_id;

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

    #[On('cancel-confirmed')]
    public function cancelOrder(){
        $ord = OrderItem::find($this->cancel_id);
        if($ord){
            $ord->vendor_status = "Canceled";
            $ord->save();

            $stn = Setting::where('name', 'service_fee')->first();

            $amount = ($stn->value / 100) * $ord->price;
            Transaction::create([
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
            $ord->save();
        }
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
