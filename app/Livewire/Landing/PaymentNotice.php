<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Order;
use App\Models\OrderItem;

use Request;

class PaymentNotice extends Component
{
    
    public function mount(){
        // $this->order_id = $id;
        // $this->status = $status;
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        $status = Request::input('status');
        return view('livewire.landing.payment-notice', [
            'status' => $status
        ]);
    }
}
