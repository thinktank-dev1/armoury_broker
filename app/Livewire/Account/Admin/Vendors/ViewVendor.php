<?php

namespace App\Livewire\Account\Admin\Vendors;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Vendor;
use App\Models\Product;

class ViewVendor extends Component
{
    use WithPagination;

    public $vendor = [];

    public function mount($id){
        $this->vendor = Vendor::find($id);
    }

    public function render(){
        $products = Product::where('vendor_id', $this->vendor->id)->paginate(12);
        return view('livewire.account.admin.vendors.view-vendor', [
            'products' => $products
        ]);
    }
}
