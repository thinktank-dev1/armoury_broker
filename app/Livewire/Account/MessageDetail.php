<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;
use App\Models\Message;

class MessageDetail extends Component
{
    public $msg_id;
    public $message;

    public function mount($id){
        $this->msg_id = $id;
    }

    public function sendMessage(){
        $this->validate([
            'message' => "required"
        ]);
        $c_msg = Message::find($this->msg_id);
        $parent = $c_msg->id;
        if($c_msg->parent_id){
            $parent = $c_msg->parent_id;
        }

        $msg = Message::create([
            'user_id' => Auth::user()->id,
            'vendor_id' => $c_msg->vendor_id,
            'from' => Auth::user()->id,
            'to' => $c_msg->user_id,
            'message' => $this->message,
            'parent_id' => $parent,
        ]);
        $this->message = null;
        session()->flash('status', 'Message sent successfully.');
    }

    public function render(){
        $messages = null;

        $msg = Message::find($this->msg_id);
        $msg->status = 1;
        $msg->save();

        if($msg->parent_id){
            $messages = Message::where('id', $msg->parent_id)->orWhere('parent_id', $msg->parent_id)->orderBy('created_at', 'ASC')->get();
        }
        else{
            $messages = Message::where('id', $this->msg_id)->orWhere('parent_id', $this->msg_id)->orderBy('created_at', 'ASC')->get();
        }
        
        return view('livewire.account.message-detail', [
            "messages" => $messages
        ]);
    }
}
