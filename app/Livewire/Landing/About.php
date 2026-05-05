<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;

class About extends Component
{
    #[Layout('components.layouts.landing')]
    public function render(){
        $user_count = User::where('status', 1)->count();
        $product_count = Product::where('status', 1)->count();
        $sold_count = OrderItem::whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->count();

        return view('livewire.landing.about', [
            'user_count' => $user_count,
            'product_count' => $product_count,
            'sold_count' => $sold_count,
        ]);
    }
}
