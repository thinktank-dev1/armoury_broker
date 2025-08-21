<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;
use App\Models\Order;

class Purchases extends Component
{
    public function setOrderReceived($id){
        $ord = Order::find($id);
        if($ord){
            $ord->receipt_status = 1;
            $ord->save();
        }
    }

    public function render(){
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return view('livewire.account.purchases', [
            'orders' => $orders
        ]);
    }
}
