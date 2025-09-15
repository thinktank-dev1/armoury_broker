<?php

namespace App\Livewire\Account\Profile;

use Livewire\Component;

use Auth;
use App\Models\Dealer;

class DealerForm extends Component
{
    public $business_name, $business_reg_number, $vat_number, $license_number, $street, $suburb, $town, $postal_code, $province, $billing_contact, $billing_email, $billing_contact_number, $dealer_stocking_fee; 
    
    public function mount(){
        $this->getData();
    }

    public function saveDealer(){
        $this->validate([
            'business_name' => 'required', 
            'business_reg_number' => 'required',
            'vat_number' => 'required',
            'license_number' => 'required',
            'street' => 'required',
            'suburb' => 'required',
            'town' => 'required',
            'postal_code' => 'required',
            'province' => 'required',
            'billing_contact' => 'required',
            'billing_email' => 'required',
            'billing_contact_number' => 'required',
            'dealer_stocking_fee' => 'required', 
        ]);

        $new = false;

        $dl = Dealer::where('user_id', Auth::user()->id)->first();
        if(!$dl){
            $dl = new Dealer();
            $new = true;
        }

        $dl->user_id = Auth::user()->id;
        if($new){
            $dl->status = 0;
            $dl->ab_dealer_network_agreement = 1;
            $dl->license_agreement = 1;
            $dl->fee_agreement = 1;
        }

        $dl->business_name = $this->business_name;
        $dl->business_reg_number = $this->business_reg_number; 
        $dl->vat_number = $this->vat_number;
        $dl->license_number = $this->license_number;
        $dl->street = $this->street;
        $dl->suburb = $this->suburb;
        $dl->town = $this->town;
        $dl->postal_code = $this->postal_code;
        $dl->province = $this->province;
        $dl->billing_contact = $this->billing_contact;
        $dl->billing_email = $this->billing_email;
        $dl->billing_contact_number = $this->billing_contact_number;
        $dl->dealer_stocking_fee = $this->dealer_stocking_fee;

        $dl->save();

        session()->flash('status', 'Dealer saved successfully.');
    }

    public function getData(){
        $dl = Dealer::where('user_id', Auth::user()->id)->first();
        if($dl){
            $this->business_name = $dl->business_name;
            $this->business_reg_number = $dl->business_reg_number;
            $this->vat_number = $dl->vat_number;
            $this->license_number = $dl->license_number;
            $this->street = $dl->street;
            $this->suburb = $dl->suburb;
            $this->town = $dl->town;
            $this->postal_code = $dl->postal_code;
            $this->province = $dl->province;
            $this->billing_contact = $dl->billing_contact; 
            $this->billing_email = $dl->billing_email;
            $this->billing_contact_number = $dl->billing_contact_number;
            $this->dealer_stocking_fee = $dl->dealer_stocking_fee;
        }
    }

    public function render(){
        return view('livewire.account.profile.dealer-form');
    }
}
