<?php

namespace App\Livewire\Account\Partials;

use Livewire\Component;

use Auth;

use App\Models\MessageThread;
use App\Models\Message;

class Header extends Component
{
    public function render(){
        $msg_count = null;
        if(Auth::user()->vendor_id){
            $msg_count = Message::query()
            ->whereHas('thread', function($q){
                return $q->where('user_1', Auth::user()->id)
                ->orWhere('user_2', Auth::user()->id);
            })
            ->where('user_id', '<>', Auth::user()->id)
            ->where('read_status', 0)
            ->count();
        }
        return view('livewire.account.partials.header', [
            'msg_count' => $msg_count
        ]);
    }
}
