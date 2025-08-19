<?php

namespace App\Livewire\Account\Admin\Products;

use Livewire\Component;

use App\Models\Product;

class AdminPoductsView extends Component
{
    public $product = [], $vendor = [];

    public function mount($id){
        $this->product = Product::find($id);
        $this->vendor = $this->product->vendor;
    }

    public function render(){
        return view('livewire.account.admin.products.admin-poducts-view');
    }
}
