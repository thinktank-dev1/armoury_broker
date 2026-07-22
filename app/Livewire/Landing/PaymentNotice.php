<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Order;
use App\Models\OrderItem;

use Request;
use Illuminate\Support\Facades\Artisan;

class PaymentNotice extends Component
{
    
    public function mount(){
        Artisan::call('app:track-tranactions');
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        $status = Request::input('status');
        return view('livewire.landing.payment-notice', [
            'status' => $status
        ]);
    }
}
