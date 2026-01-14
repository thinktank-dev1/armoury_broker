<?php

namespace App\Livewire\Account\Admin\Products;

use Livewire\Component;

use App\Models\Product;

class AdminPoductsView extends Component
{
    public $product = [], $vendor = [];
    public $prdt_id;

    public function mount($id){
        $this->prdt_id = $id;
    }

    public function disableProduct($id){
        $prdt = Product::find($id);
        if($prdt){
            $prdt->status = 0;
            $prdt->save();
        }
    }

    public function activateProduct($id){
        $prdt = Product::find($id);
        if($prdt){
            $prdt->status = 1;
            $prdt->save();
        }
    }

    public function render(){
        $this->product = Product::find($this->prdt_id);
        $this->vendor = $this->product->vendor;
        return view('livewire.account.admin.products.admin-poducts-view');
    }
}
