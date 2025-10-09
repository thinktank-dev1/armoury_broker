<?php

namespace App\Livewire\Account\Profile;

use Livewire\Component;

use App\Livewire\Account\Profile;
use Auth;

class VendorDetails extends Component
{
    public $provinces = [];
    public $name, $decription, $instagram_handle, $suburb, $city, $province;
    public $dealer_stock_service, $show_dealer_opt_in;

    public function mount(){
        $vnd = Auth::user()->vendor;
        $this->name = $vnd->name; 
        $this->decription = $vnd->description;
        $this->instagram_handle = $vnd->instagram_handle; 
        $this->suburb = $vnd->suburb;
        $this->city = $vnd->city; 
        $this->province = $vnd->province;

        $this->provinces = [
            'Eastern Cape', 
            'Free State', 
            'Gauteng', 
            'KwaZulu-Natal', 
            'Limpopo', 
            'Mpumalanga', 
            'Northern Cape', 
            'North West',
            'Western Cape' 
        ];
        $this->show_dealer_opt_in = False;
        $this->join_dealer_network = False;
    }

    public function updatedDealerStockService(){
        if($this->dealer_stock_service){
            $this->show_dealer_opt_in = True;
        }
        else{
            $this->show_dealer_opt_in = False;
        }
    }

    public function saveVendor(){
        $this->validate([
            'name' => 'required', 
            'decription' => 'required', 
        ]);
        $vnd = Auth::user()->vendor;
        $vnd->name = $this->name; 
        $vnd->description = $this->decription;
        $vnd->instagram_handle = $this->instagram_handle;
        $vnd->suburb = $this->suburb; 
        $vnd->city = $this->city; 
        $vnd->province = $this->province;
        $vnd->save();
        session()->flash('status', 'Vendor successfully updated.');
    }

    public function render(){
        return view('livewire.account.profile.vendor-details');
    }
}
