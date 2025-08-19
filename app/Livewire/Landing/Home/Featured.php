<?php

namespace App\Livewire\Landing\Home;

use Livewire\Component;

use App\Models\Product;

class Featured extends Component
{
    public function render(){
        $products = Product::where('featured', 1)->inRandomOrder()->get();
        return view('livewire.landing.home.featured', [
            'products' => $products
        ]);
    }
}
