<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Log;
use App\Models\Order;
use App\Models\OrderItem;

use Request;
use Illuminate\Support\Facades\Artisan;

class PaymentNotice extends Component
{
    
    public function mount(){
        //Artisan::call('app:track-tranactions');
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        $status = Request::input('status');
        $order_ref = Request::input('id');

        $order = Order::where('uuid', $order_ref)->first();
        $order_no = 'AB-ORD-'.str_pad($order->id, 4, '0', STR_PAD_LEFT);

        Log::info(Request::all()); 

        return view('livewire.landing.payment-notice', [
            'status' => $status,
            'order_no' => $order_no,
            'order' => $order,
        ]);
    }
}
