<?php

namespace App\Livewire\Landing\Home;

use Livewire\Component;

use App\Models\Brand;

class Brands extends Component
{
    public function render(){
        $brands = Brand::where('featured', 1)->orderBy('brand_name', 'ASC')->get();
        return view('livewire.landing.home.brands', [
            'brands' => $brands
        ]);
    }
}
