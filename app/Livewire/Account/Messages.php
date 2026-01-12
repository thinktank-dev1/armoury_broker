<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Lib\Communication;

use Auth;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\OfferPrice;
use App\Models\User;

class Messages extends Component
{
    use WithFileUploads;

    public $read_type;
    public $active_id;
    public $cur_msg;
    public $message;
    public $counter_amount, $cur_action_msg;
    public $message_attachment;

    public function mount($id = null){
        if($id){
            $this->active_id = $id;
        }
        else{
            $msg = MessageThread::where(function($q){
                return $q->where('user_1', Auth::user()->id)->orWhere('user_2', Auth::user()->id);
            })
            ->whereHas('messages')
            ->withMax('messages', 'created_at')
            ->orderByDesc('messages_max_created_at') 
            ->first();
            if($msg){
                $this->active_id = $msg->id;
            }
        }
        $this->getData();
    }

    public function removeAttachment(){
        $this->message_attachment = null;
    }

    public function changeType($type){
        $this->read_type = $type;
    }

    public function markAsViewed($id){
        $msg = Message::find($id);
        if($msg->user_id != Auth::user()->id){
            if($msg->read_status == 0){
                $msg->update(['read_status' => 1]);
            }
        }
    }

    public function showCounterModal($id){
        $this->cur_action_msg = $id;
        $this->dispatch('show-offer-modal');
    }

    public function saveCounterOffer(){
        $this->validate([
            'counter_amount' => 'required',
        ]);

        if($this->cur_action_msg){
            $p_msg = Message::find($this->cur_action_msg);
            if($p_msg){
                $p_msg->action = "countered";
                $p_msg->save();
            }
        }

        $msg = new Message();
        $msg->message_thread_id = $this->active_id;
        $msg->user_id = Auth::user()->id;
        $msg->message = "You have a new counter offer";
        $msg->offer_amount = $this->counter_amount;
        $msg->save();

        $thread = $msg->thread;
        if($thread->product_id){
            $product = $thread->product;
             
            $order_data = "<table class='table-bodered' style='width: 100%'>";
            $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>Offer Details</th></tr></thead>";
            $order_data .= "<tbody>";
            $order_data .= "<tr>";

            if($product->images->count() > 0){
                $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$product->images->first()->image_url)."'></td>";
            }
            else{
                $order_data .= "<td></td>";
            }
            $order_data .= "<td>";
            $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
            $order_data .= "<tr><td>Item Name:</td><td>".$product->item_name."</td></tr>";
            $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($product->item_price,2)."</td></tr>";
            $order_data .= "<tr><td>Your Offered Price:</td><td>R ".number_format($p_msg->offer_amount,2)."</td></tr>";
            $order_data .= "<tr><td>Counter Offer Price:</td><td>R ".number_format($msg->offer_amount,2)."</td></tr>";
            $order_data .= "</table>";
            $order_data .= "</td>";

            $order_data .= "</tr>";
            $order_data .= "</tbody>";
            $order_data .= "</table>";


            $body = "The seller has made a counter offer on your item!<br /><br />
            Good news — the seller has responded to your offer on <b>".$product->item_name."</b><br /><br />
            They’ve made a counter offer of <b>R".number_format($msg->offer_amount,2)."</b>.<br />
            You can review the details and decide whether to <b>accept</b> or <b>decline</b><br />.".$order_data;

            $after = "Please note: counter offers are time-sensitive and may expire if no action is taken.";

            $user = $p_msg->user;
            $data = [
                'to' => $user->email,
                'name' => $user->name,
                'subject' => 'New Counter Offer',
                'title' => "New Counter Offer",
                'message_body' => $body,
                'cta' => true,
                'cta_text' => 'View Offer',
                'cta_url' => url('messages/'.$thread->id),
                'after_cta_body' => $after,
            ];
            $comm = new Communication();
            $comm->sendMail($data);
        }

        $this->message = null;
        $this->counter_amount = null;
        $this->cur_action_msg = null;
        $this->dispatch('close-modal');
    }

    public function changeActionStatus($id, $action){
        $msg = Message::find($id);
        if($msg){
            $msg->action = $action;
            $msg->save();

            if($action == 'accept'){
                $thread = $msg->thread;
                $prdt = $thread->product;
                if($prdt){
                    $user_id = null;
                    if($prdt->user->id != $thread->user_1){
                        $user_id = $thread->user_1;
                    }
                    elseif($prdt->user->id != $thread->user_2){
                        $user_id = $thread->user_2;
                    }
                    if($user_id){
                        OfferPrice::create([
                            'user_id' => $user_id,
                            'product_id' => $thread->product->id,
                            'amount' => $msg->offer_amount,
                        ]);
                    }
                }
            }
        }
    }

    public function cancelOffer($id){
        $msg = Message::find($id);
        if($msg){
            // $msg->delete();
            $msg->action  = 'canceled';
            $msg->save();
        }
    }

    public function sendMessage(){
        $file = null;
        if($this->message_attachment){
            $file = $this->message_attachment->storePublicly('message_attachments', 'public');
        }

        if($this->message){
            $msg = new Message();
            $msg->message_thread_id = $this->active_id;
            $msg->user_id = Auth::user()->id;
            $msg->message = $this->message;
            if($file){
                $msg->attachment = $file;
            }
            $msg->save();
            $this->message = null;
            $this->message_attachment = null;
        }
        elseif($file){
            $msg = new Message();
            $msg->message_thread_id = $this->active_id;
            $msg->user_id = Auth::user()->id;
            $msg->message = "User sent a file";
            $msg->attachment = $file;
            $msg->save();
            $this->message = null;
            $this->message_attachment = null;
        }
    }

    public function changeCurMessage($id){
        $this->active_id = $id;
        $this->getData();
    }

    public function getData(){
        if($this->active_id){
            $msg = MessageThread::find($this->active_id);
            if($msg){
                $this->cur_msg = $msg;
            }
        }
    }

    public function render(){
        $read_status = $this->read_type;
        $mesages = MessageThread::where(function($q){
            return $q->where('user_1', Auth::user()->id)->orWhere('user_2', Auth::user()->id);
        })
        ->whereHas('messages')
        ->withMax('messages', 'created_at')
        ->orderByDesc('messages_max_created_at') 
        ->when($read_status, function($q) use($read_status) {
            return $q->whereHas('messages', function($qq) use($read_status){
                if($read_status == "unread"){
                    return $qq->where('read_status', 0);
                }
                if($read_status == "read"){
                    return $qq->where('read_status', 1);
                }
            });
        })
        ->get();

        return view('livewire.account.messages', [
            'mesages' => $mesages
        ]);
    }
}