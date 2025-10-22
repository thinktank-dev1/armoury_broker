<?php

namespace App\Livewire\Account\MyArmoury;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Lib\Communication;

use Auth;
use App\Models\Vendor;
use App\Models\Dealer;
use App\Models\Message;
use App\Models\MessageThread;

class EditMyArmoury extends Component
{
    use WithFileUploads;

    public $provinces = [];
    public $armoury_name, $instagram_handle, $suburb, $city, $province, $bio, $avatar;
    public $dealer_stock_service, $join_dealer_network;
    public $business_name, $business_reg_number, $vat_number, $license_number, $d_street, $d_suburb, $d_town, $postal_code, $d_province, $billing_contact, $billing_email, $billing_contact_number, $dealer_stocking_fee, $ab_dealer_network_agreement, $license_agreement, $fee_agreement;
    public $view, $btn_text;
    public $terms_agreement;

    public function mount(){
        $this->setStaticData();
        $this->getData();

        $this->btn_text = "SAVE";
        $this->view = "armoury";
    }

    public function updatedDealerStockService(){
        if($this->dealer_stock_service){
            $this->btn_text = "NEXT";
        }
        else{
            $this->btn_text = "SAVE";
        }
    }

    public function saveArmoury(){
        $this->validate([
            'armoury_name' => 'required', 
            'suburb' => 'required',
            'city' => 'required',
            'province' => 'required',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp',
        ]);

        if(Auth::user()->vendor_id && Vendor::find(Auth::user()->vendor_id)){
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
        $vendor->suburb = $this->suburb;
        $vendor->city = $this->city;
        $vendor->province = $this->province;
        if(!Auth::user()->vendor_id){
            $vendor->status = 1;
        }
        $vendor->instagram_handle = $this->instagram_handle;
        $vendor->save();
        if(!Auth::user()->vendor_id){
            $tr = MessageThread::create([
                'user_1' => 1,
                'user_2' => Auth::user()->id,
            ]);
            Message::create([
                'message_thread_id' => $tr->id,
                'user_id' => 1,
                'message' => "Welcome to armory broker.",
                'read_status' => 0,
            ]);
        }

        Auth::user()->vendor_id = $vendor->id;
        Auth::user()->save();
        $this->getData();

        if($this->dealer_stock_service){
            $this->view = "dealer";
        }
        else{
            session()->flash('status', 'Vendor successfully saved.');
            $this->dispatch('success-message', message: "Vendor successfully saved.");
            $this->sendWelcomeMessage();
            $this->redirect('/my-armoury'); 
        }
    }

    public function saveDealer(){
        if($this->join_dealer_network){
            $this->validate([
                'business_name' => 'required', 
                'license_number' => 'required',  
                'dealer_stocking_fee' => 'required', 
                'ab_dealer_network_agreement' => 'required', 
                'license_agreement' => 'required', 
                'fee_agreement' => 'required',
                'terms_agreement' => 'required',
            ]);
            $dealer = Dealer::where('user_id', Auth::user()->id)->first();
            if(!$dealer){
                $dealer = new Dealer();
            }
            $dealer->user_id = Auth::user()->id;
            $dealer->status = 0;

            $dealer->business_name = $this->business_name;
            $dealer->business_reg_number = $this->business_reg_number;
            $dealer->vat_number = $this->vat_number;
            $dealer->license_number = $this->license_number;

            $dealer->street = $this->d_street;
            $dealer->suburb = $this->d_suburb;
            $dealer->town = $this->d_town;
            $dealer->postal_code = $this->postal_code;
            $dealer->province = $this->d_province;
            $dealer->billing_contact = $this->billing_contact;
            $dealer->billing_email = $this->billing_email;
            $dealer->billing_contact_number = $this->billing_contact_number;
             
            $dealer->dealer_stocking_fee = $this->dealer_stocking_fee;

            $dealer->ab_dealer_network_agreement = $this->ab_dealer_network_agreement; 
            $dealer->license_agreement = $this->license_agreement;
            $dealer->fee_agreement = $this->fee_agreement;
            $dealer->save();

            session()->flash('status', 'Dealer successfully saved. The team will review your details and add you to the dealer network.');
            $this->dispatch('success-message', message: "Dealer successfully saved. The team will review your details and add you to the dealer network.");
            $this->sendWelcomeMessage();
            $this->redirect('/my-armoury');
        }
        else{
            $this->sendWelcomeMessage();
            $this->redirect('/my-armoury');
        }
    }

    public function sendWelcomeMessage(){
        $comm = new Communication();    
        $user = Auth::user();

        $body = "Thank you for joining South Africa's premier secure marketplace for armoury and related equipment. You're now part of a trusted community transforming how firearms owners buy, sell, and trade equipment in a safe and secure environment.<br /><br />
        <b>Your Platform Benefits</b><br />
        <ul>
            <li>Personalized ecommerce store</li>
            <li>Secure Escrow Payments</li>
            <li>End-to-End Buyer and Seller Protection</li>
            <li>Transparent Transaction History</li>
        </ul>
        <br />
        <b>Ready to get started?</b><br /><br />
        Browse quality equipment from verified sellers, list your unused gear, or explore competitive prices in a trusted environment";

        $after = "You no longer need to hope that an item will be delivered or hope that you will get paid:<br /><br />
        Every transaction is protected, tracked, and secure from start to finish.<br /><br />
        It’s time for you to <b>LEVEL UP!</b>";

        $data = [
            'to' => $user->email,
            'name' => $user->name,
            'subject' => 'Welcome to Armoury Broker',
            'title' => "Verify your details",
            'message_body' => $body,
            'cta' => true,
            'cta_text' => 'Shop Now',
            'cta_url' => url('/'),
            'after_cta_body' => $after,
        ];
        $comm->sendMail($data);
    }

    public function getData(){
        if(Auth::user()->vendor_id){
            $vendor = Vendor::find(Auth::user()->vendor_id);
            if($vendor){
                $this->bio = $vendor->description;
                $this->tel = $vendor->tel;
                $this->email = $vendor->email;
                $this->street = $vendor->street;
                $this->suburb = $vendor->suburb;
                $this->city = $vendor->city;
                $this->armoury_name = $vendor->name;
                $this->province = $vendor->province;
                $this->postal_code = $vendor->postal_code;
                $this->instagram_handle = $vendor->instagram_handle;
            }

            $dealer = Dealer::where('user_id', Auth::user()->id)->first();
            if($dealer){
                $this->business_name = $dealer->business_name;
                $this->business_reg_number = $dealer->business_reg_number;
                $this->vat_number = $dealer->vat_number;
                $this->license_number = $dealer->license_number;
                $this->d_street = $dealer->street;
                $this->d_suburb = $dealer->suburb;
                $this->d_town = $dealer->town;
                $this->postal_code = $dealer->postal_code;
                $this->d_province = $dealer->province;
                $this->billing_contact = $dealer->billing_contact;
                $this->billing_email = $dealer->billing_email;
                $this->billing_contact_number = $dealer->billing_contact_number;
                $this->dealer_stocking_fee = $dealer->dealer_stocking_fee;

                $this->dealer_stock_service = true;
                $this->join_dealer_network = true;
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

    public function render(){
        return view('livewire.account.my-armoury.edit-my-armoury');
    }
}
