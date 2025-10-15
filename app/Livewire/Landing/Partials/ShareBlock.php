<?php

namespace App\Livewire\Landing\Partials;

use Livewire\Component;

use Auth;
use App\Models\Vendor;
use App\Models\VendorLike;
use App\Models\Message;
use App\Models\MessageThread;

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
        $this->link = url($this->vendor->url_name);
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

        $thread = new MessageThread();
        $thread->user_1 = $this->vendor->user->id;
        if(Auth::user()){
            $thread->user_2 = Auth::user()->id;
        }
        $thread->name = $this->name;
        $thread->surname = $this->surname;
        $thread->email = $this->email;
        $thread->contact_number = $this->contact_number;
        $thread->save();
        
        $msg = new Message();
        $msg->message_thread_id = $thread->id;
        if(Auth::user()){
            $msg->user_id = Auth::user()->id;
        }
        $msg->message = $this->message;
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
