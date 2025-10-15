<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;
use App\Models\Message;
use App\Models\MessageThread;

class Messages extends Component
{
    public $read_type;
    public $active_id;
    public $cur_msg;
    public $message;

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

    public function sendMessage(){
        if($this->message){
            $msg = new Message();
            $msg->message_thread_id = $this->active_id;
            $msg->user_id = Auth::user()->id;
            $msg->message = $this->message;
            $msg->save();
            $this->message = null;
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
        $mesages = MessageThread::where(function($q){
            return $q->where('user_1', Auth::user()->id)->orWhere('user_2', Auth::user()->id);
        })
        ->whereHas('messages')
        ->withMax('messages', 'created_at')
        ->orderByDesc('messages_max_created_at') 
        ->get();

        return view('livewire.account.messages', [
            'mesages' => $mesages
        ]);
    }
}
