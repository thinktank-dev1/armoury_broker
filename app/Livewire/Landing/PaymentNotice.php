<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Order;
use App\Models\OrderItem;

class PaymentNotice extends Component
{
    public $order_id, $status;
    
    public function mount($id, $status){
        $this->order_id = $id;
        $this->status = $status;
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.landing.payment-notice');
    }
}
