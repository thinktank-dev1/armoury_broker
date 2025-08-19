<?php

namespace App\Livewire\Account\MyArmoury;

use Livewire\Component;
use Livewire\WithFileUploads;

use Auth;
use App\Models\Vendor;
use App\Models\Dealer;

class EditMyArmoury extends Component
{
    use WithFileUploads;

    public $provinces = [];
    public $armoury_name, $tel, $email, $instagram_handle, $street, $suburb, $city, $postal_code, $province, $bio, $avatar;
    public $dealer_stock_service, $join_dealer_network;
    public $business_name, $license_number, $business_street, $business_suburb, $business_city, $business_postal_code, $business_province, $dealer_stocking_fee, $ab_dealer_network_agreement, $license_agreement, $fee_agreement;

    public function mount(){
        $this->setStaticData();
        $this->getData();
    }

    public function updatedDealerStockService(){
        if($this->dealer_stock_service){
            $this->dispatch('go-to-top');
        }
    }

    public function saveArmoury(){
        $this->validate([
            'armoury_name' => 'required',
            'tel' => 'required', 
            'email' => 'required',
            'street' => 'required',
            'suburb' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'province' => 'required',
        ]);
        if(Auth::user()->vendor_id){
            $vendor = Vendor::find(Auth::user()->vendor_id);
        }
        else{
            $vendor = new Vendor();
        }

        $file_url = null;
        if($this->avatar){
            $file_url = $this->avatar->storePublicly('vendor_avater', 'public');
        }

        $base = $this->slugify($this->armoury_name);
        $newName = $base;
        $i = 1;
        while(Vendor::where('url_name', $newName)->first()){
            $newName = $base . $i;
            $i++;
        }

        $vendor->name = $this->armoury_name;
        $vendor->url_name = $newName;
        if($file_url){
            $vendor->avatar = $file_url;
        }
        $vendor->description = $this->bio;
        $vendor->tel = $this->tel;
        $vendor->email = $this->email;
        $vendor->street = $this->street;
        $vendor->suburb = $this->suburb;
        $vendor->city = $this->city;
        $vendor->country = "South Africa";
        $vendor->status = 1;
        $vendor->save();

        Auth::user()->vendor_id = $vendor->id;
        Auth::user()->save();
        $this->getData();

        session()->flash('status', 'Vendor successfully saved.');

        if($this->join_dealer_network){
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
            $dealer = Dealer::where('user_id', Auth::user()->id)->first();
            if(!$dealer){
                $dealer = new Dealer();
            }
            $dealer->user_id = Auth::user()->id;
            $dealer->status = 0;
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

            session()->flash('status', 'Dealer successfully saved. The team will review your details and add you to the dealer network');
        }
    }

    public function getData(){
        if(Auth::user()->vendor_id){
            $vendor = Vendor::find(Auth::user()->vendor_id);
            if($vendor){
                $this->bio = $vendor->biography;
                $this->tel = $vendor->tel;
                $this->email = $vendor->email;
                $this->street = $vendor->street;
                $this->suburb = $vendor->suburb;
                $this->city = $vendor->city;
                $this->armoury_name = $vendor->name;
            }

            $dealer = Dealer::where('user_id', Auth::user()->id)->first();
            if($dealer){
                $this->dealer_stock_service = true;
                $this->join_dealer_network = true;

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
    }

    public function setStaticData(){
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
    
    public function slugify($string){
        $string = strtolower($string);
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        $string = trim($string, '-');
        return $string;
    }
    public function render()
    {
        return view('livewire.account.my-armoury.edit-my-armoury');
    }
}
