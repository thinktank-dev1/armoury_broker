<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;
use App\Models\Message;
use App\Models\OrderItem;
use App\Models\Vendor;

class MessageDetail extends Component
{
    public $msg_id;
    public $message;
    public $order_item_id, $order_item;

    public function mount($id = null){
        if(isset($_GET['order-item'])){
            $itm = OrderItem::find($_GET['order-item']);
            if($itm->user_id == Auth::user()->id or $itm->vendor_id = Auth::user()->vendor_id){
                $this->order_item = $itm;
                $this->order_item_id = $_GET['order-item'];
            }
        }
        elseif($id){
            $this->msg_id = $id;
            $msg = Message::find($this->msg_id);
            if($msg){
                if($msg->order_item_id){
                    $this->order_item = OrderItem::find($msg->order_item_id);
                    $this->order_item_id = $this->order_item->id;
                }
            }
        }
    }

    public function sendMessage(){
        $this->validate([
            'message' => "required"
        ]);
        $parent = null;
        $to = null;
        $vendor_id = null;
        $user_id = null;

        if($this->order_item_id){
            $c_msg = Message::where('order_item_id', $this->order_item_id)->whereNull('parent_id')->first();
            if($c_msg){
                $parent = $c_msg->id;
            }
            if($this->order_item){
                $vendor_id = $this->order_item->vendor_id;
                $user_id = $this->order_item->user_id;
                if(Auth::user()->vendor_id == $vendor_id){
                    $to = $this->order_item->user_id;
                }
                else{
                    $to = $this->order_item->vendor->user->id;
                }
            }
        }
        else{
            $c_msg = Message::find($this->msg_id);
            $parent = $c_msg->id;
            if($c_msg->parent_id){
                $parent = $c_msg->parent_id;
            }
            $vendor_id = $c_msg->vendor_id;
            $user_id = $c_msg->user_id;
            if(Auth::user()->vendor_id == $vendor_id){
                $to = $c_msg->user_id;
            }
            else{
                $vnd = Vendor::find($vendor_id);
                $to = $vnd->use->id;
            }
        }

        $msg = Message::create([
            'user_id' => $user_id,
            'vendor_id' => $vendor_id,
            'order_item_id' => $this->order_item_id,
            'from' => Auth::user()->id,
            'to' => $to,
            'message' => $this->message,
            'parent_id' => $parent,
        ]);
        $this->message = null;
        session()->flash('status', 'Message sent successfully.');
    }

    public function render(){
        $messages = null;

        if($this->order_item_id){
            $msg = Message::where('order_item_id', $this->order_item_id)->whereNull('parent_id')->first();
            if($msg){
                $messages = Message::where('id', $msg->id)->orWhere('parent_id', $msg->id)->orderBy('created_at', 'ASC')->get();
            }
        }
        if($this->msg_id){
            $msg = Message::find($this->msg_id);
            $msg->status = 1;
            $msg->save();

            if($msg->parent_id){
                $messages = Message::where('id', $msg->parent_id)->orWhere('parent_id', $msg->parent_id)->orderBy('created_at', 'ASC')->get();
            }
            else{
                $messages = Message::where('id', $this->msg_id)->orWhere('parent_id', $this->msg_id)->orderBy('created_at', 'ASC')->get();
            }
        }
        
        return view('livewire.account.message-detail', [
            "messages" => $messages
        ]);
    }
}
