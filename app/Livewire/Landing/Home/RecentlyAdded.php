<?php

namespace App\Livewire\Landing\Home;

use Livewire\Component;

use Auth;
use App\Models\Product;
use App\Models\WishList;

class RecentlyAdded extends Component
{
    public function render(){
        $products = Product::orderBy('created_at', 'DESC')->take(12)->get();
        return view('livewire.landing.home.recently-added', [
            'products' => $products
        ]);
    }
}
