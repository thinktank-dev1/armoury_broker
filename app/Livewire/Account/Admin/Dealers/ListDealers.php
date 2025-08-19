<?php

namespace App\Livewire\Account\Admin\Dealers;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Dealer;

class ListDealers extends Component
{
    use WithPagination;
    public $search_key;

    public function updatedSearchKey(){
        $this->resetPage();
    }

    public function render(){
        $key = $this->search_key;

        $dealers = Dealer::query()
        ->orderBy('business_name', 'ASC')
        ->when($key, function($q){
            return $q->where('business_name', 'LIKE', '%'.$key.'%')
            ->orWhere('license_number', 'LIKE', '%'.$key.'%')
            ->orWhere('business_suburb', 'LIKE', '%'.$key.'%')
            ->orWhere('business_city', 'LIKE', '%'.$key.'%')
            ->orWhere('business_province', 'LIKE', '%'.$key.'%');
        })
        ->paginate(12);

        return view('livewire.account.admin.dealers.list-dealers', [
            'dealers' => $dealers
        ]);
    }
}
