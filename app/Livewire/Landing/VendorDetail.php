<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Auth;
use App\Models\Vendor;
use App\Models\Product;

class VendorDetail extends Component
{
    public $vendor;
    
    public function mount($url_name){
        $this->vendor = Vendor::where('url_name', $url_name)->first();
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        $products = [];
        if($this->vendor){
            $products = Product::query()
            ->where('vendor_id', $this->vendor->id)
            ->get();
        }

        return view('livewire.landing.vendor-detail', [
            'products' => $products
        ]);
    }
}
