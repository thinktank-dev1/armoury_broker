<?php

namespace App\Livewire\Account\Profile;

use Livewire\Component;

use Auth;

class VendorDetails extends Component
{
    public $name, $decription, $tel, $email, $street, $suburb, $city, $country;

    public function mount(){
        $vnd = Auth::user()->vendor;
        $this->name = $vnd->name; 
        $this->decription = $vnd->description;
        $this->tel = $vnd->tel;
        $this->email = $vnd->email;
        $this->street = $vnd->street;
        $this->suburb = $vnd->suburb;
        $this->city = $vnd->city;
        $this->country = $vnd->country;
    }

    public function saveVendor(){
        $this->validate([
            'name' => 'required', 
            'decription' => 'required', 
            'tel' => 'required', 
            'email' => 'required', 
            'street' => 'required', 
            'suburb' => 'required', 
            'city' => 'required', 
            'country' => 'required'
        ]);
        $vnd = Auth::user()->vendor;
        $vnd->name = $this->name; 
        $vnd->description = $this->decription;
        $vnd->tel = $this->tel;
        $vnd->email = $this->email;
        $vnd->street = $this->street;
        $vnd->suburb = $this->suburb;
        $vnd->city = $this->city;
        $vnd->country = $this->country;
        $vnd->save();
        session()->flash('status', 'Vendor successfully updated.');
    }

    public function render(){
        return view('livewire.account.profile.vendor-details');
    }
}
