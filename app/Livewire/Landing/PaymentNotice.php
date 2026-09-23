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
        $order_no = Request::input('reference');

        $id = (int)preg_replace('/[^0-9]/', '', $order_no);
        $order = Order::find($id);

        Log::info(Request::all()); 

        return view('livewire.landing.payment-notice', [
            'status' => $status,
            'order_no' => $order_no,
            'order' => $order,
        ]);
    }
}
