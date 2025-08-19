<?php

namespace App\Livewire\Landing\Partials;

use Livewire\Component;

use Auth;
use App\Models\Vendor;
use App\Models\VendorLike;
use App\Models\Message;

class ShareBlock extends Component
{
    public $vendor_id, $view_type;
    public $vendor = [];
    public $link;

    public $name, $surname, $email, $contact_number, $message;

    public function mount($vendor_id, $type){
        $this->vendor_id = $vendor_id;
        $this->view_type = $type;
        $this->vendor = Vendor::find($vendor_id);
    }

    public function likeVendor(){
        $lk = VendorLike::where('user_id', Auth::user()->id)->where('vendor_id', $this->vendor->id)->first();
        if($lk){
            $lk->delete();
        }
        else{
            VendorLike::create([
                'user_id' => Auth::user()->id,
                'vendor_id' => $this->vendor->id
            ]);
        }
    }

    public function saveMessage(){
        if(Auth::guest()){
            $rules = [
                'name' => 'required', 
                'surname' => 'required', 
                'email' => 'required', 
                'contact_number' => 'required',
                'message' => 'required',
            ];
        }
        else{
            $rules = [
                'message' => 'required'
            ];
        }
        $this->validate($rules);
        $msg = new Message();
        if(!Auth::guest()){
            $msg->user_id = Auth::user()->id;
            $msg->from = Auth::user()->id;
            $msg->to = $this->vendor->id;
        }
        $msg->vendor_id = $this->vendor->id;
        $msg->name = $this->name;
        $msg->surname = $this->surname;
        $msg->email = $this->email;
        $msg->contact_number = $this->contact_number;
        $msg->message = $this->message;
        $msg->status = 0;
        $msg->save();
        $this->dispatch('message-sent');
    }

    public function copyLink(){
        if($this->vendor){
            $link = url($this->vendor->url_name);
            $this->link = $link;
            $this->dispatch('copy-link', link: $link);
        }
    }

    public function render(){
        return view('livewire.landing.partials.share-block');
    }
}
