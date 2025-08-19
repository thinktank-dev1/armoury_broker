<?php

namespace App\Livewire\Account\Admin\Dealers;

use Livewire\Component;

use Auth;
use App\Models\Vendor;
use App\Models\Dealer;

class DealerForm extends Component
{
    public $provinces = [];
    public $cur_id;
    public $business_name, $license_number, $business_street, $business_suburb, $business_city, $business_postal_code, $business_province, $dealer_stocking_fee, $ab_dealer_network_agreement, $license_agreement, $fee_agreement;

    public function mount($id = null){
        $this->setSaticData();
        if($id){
            $this->cur_id = $id;
            $this->getData();
        }
    }

    public function saveDealer(){
        $this->validate([
            'business_name' => 'required', 
            'license_number' => 'required', 
            'business_street' => 'required', 
            'business_suburb' => 'required', 
            'business_city' => 'required',
            'business_postal_code' => 'required', 
            'business_province' => 'required', 
            'dealer_stocking_fee' => 'required', 
            'ab_dealer_network_agreement' => 'required', 
            'license_agreement' => 'required', 
            'fee_agreement' => 'required'
        ]);
        if($this->cur_id){
            $dealer = Dealer::find($this->cur_id);    
        }
        else{
            $dealer = new Dealer();
        }
        
        $dealer->business_name = $this->business_name; 
        $dealer->license_number = $this->license_number;
        $dealer->business_street = $this->business_street;
        $dealer->business_suburb = $this->business_suburb;
        $dealer->business_city = $this->business_city;
        $dealer->business_postal_code = $this->business_postal_code;
        $dealer->business_province = $this->business_province;
        $dealer->dealer_stocking_fee = $this->dealer_stocking_fee;
        $dealer->ab_dealer_network_agreement = $this->ab_dealer_network_agreement; 
        $dealer->license_agreement = $this->license_agreement;
        $dealer->fee_agreement = $this->fee_agreement;
        $dealer->save();

        session()->flash('status', 'Dealer successfully saved.');
    }

    public function getData(){
        $dealer = Dealer::find($this->cur_id);
        if($dealer){
            $this->business_name = $dealer->business_name; 
            $this->license_number = $dealer->license_number;
            $this->business_street = $dealer->business_street;
            $this->business_suburb = $dealer->business_suburb;
            $this->business_city = $dealer->business_city;
            $this->business_postal_code = $dealer->business_postal_code;
            $this->business_province = $dealer->business_province;
            $this->dealer_stocking_fee = $dealer->dealer_stocking_fee;
            $this->ab_dealer_network_agreement = true; 
            $this->license_agreement = true;
            $this->fee_agreement = true;
        }
    }

    public function setSaticData(){
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
    }

    public function render()
    {
        return view('livewire.account.admin.dealers.dealer-form');
    }
}
