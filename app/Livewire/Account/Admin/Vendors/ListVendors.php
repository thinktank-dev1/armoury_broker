<?php

namespace App\Livewire\Account\Admin\Vendors;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Vendor;

class ListVendors extends Component
{
    use WithPagination;

    public $search_key;

    public function updatedSearchKey(){
        $this->resetPage();
    } 

    public function render(){
        $key = $this->search_key;

        $vendors = Vendor::query()
        ->when($key, function($q) use($key){
            return $q->where('name', 'LIKE', '%'.$key.'%')
            ->orWhere('description', 'LIKE', '%'.$key.'%')
            ->orWhere('tel', 'LIKE', '%'.$key.'%')
            ->orWhere('email', 'LIKE', '%'.$key.'%')
            ->orWhere('suburb', 'LIKE', '%'.$key.'%')
            ->orWhere('city', 'LIKE', '%'.$key.'%');
        })
        ->orderBy('name', 'ASC')
        ->paginate(12);
        return view('livewire.account.admin.vendors.list-vendors', [
            'vendors' => $vendors
        ]);
    }
}
