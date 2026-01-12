<?php

namespace App\Livewire\Account\Profile;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use App\Livewire\Account\Profile;
use Auth;

class VendorDetails extends Component
{
    use WithFileUploads;
    
    public $provinces = [];
    public $name, $description, $instagram_handle, $suburb, $city, $province;
    public $dealer_stock_service, $show_dealer_opt_in;
    public $avatar; 

    public function mount(){
        $vnd = Auth::user()->vendor;
        $this->name = $vnd->name; 
        $this->description = $vnd->description;
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

    public function saveAvater(){
        if($this->avatar){
            $allowed = ['image/png', 'image/jpg', 'image/jpeg', 'image/svg'];
            $tp = $this->avatar->getMimeType();

            if(!in_array($tp, $allowed)){
                $this->avatar = null;
                $this->addError('error', 'Please upload images only. (PNG, JPG, SVG)');
                return;
            }

            $file = $this->avatar->storePublicly('vendor_avater', 'public');
            $vnd = Auth::user()->vendor;
            $vnd->avatar = $file;
            $vnd->save();
        }
        $this->avatar = null;
        $this->dispatch('close-modal');
    }

    public function activateDealerTab(){
        $this->dispatch('activate-dealer-tab');
    }

    #[On('province-updated')]
    public function handleProvinceUpdate($province){
        $this->province = $province;
        $this->saveVendor();
    }

    public function updateContent($field, $value){
        $this->$field = $value;
        $this->saveVendor();
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
            'name' => 'required|unique:vendors,name,'.Auth::user()->vendor_id, 
            'description' => 'required', 
        ]);

        $vnd = Auth::user()->vendor;
        $vnd->name = $this->name; 
        $vnd->description = $this->description;
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
