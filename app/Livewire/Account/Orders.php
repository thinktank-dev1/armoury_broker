<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;
use App\Models\Vendor;
use App\Models\Order;

class Orders extends Component
{
    
    public $cur_order = [];

    public function markOrderShipped($id){
        $ord = Order::find($id);
        if($ord){
            $ord->shipping_status = 1;
            $ord->save();
        }
        $this->dispatch('close-modal');
    }

    public function showShippingModal($id){
        $ord = Order::find($id);
        if($ord){
            $this->cur_order = $ord;
            $this->dispatch('show-order-modal');
        }
    }

    public function render(){
        $order = [];
        if(Auth::user()->vendor){
            $orders = Order::where('vendor_id', Auth::user()->vendor->id)->get();
        }
        return view('livewire.account.orders', [
            'orders' => $orders
        ]);
    }
}
