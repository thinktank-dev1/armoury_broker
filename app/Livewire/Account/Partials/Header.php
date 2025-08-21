<?php

namespace App\Livewire\Account\Partials;

use Livewire\Component;

use Auth;
use App\Models\Message;

class Header extends Component
{
    public function render(){
        $msg_count = null;
        if(Auth::user()->vendor_id){
            $msg_count = Message::where('vendor_id', Auth::user()->vendor_id)->where('status', 0)->count();
        }
        return view('livewire.account.partials.header', [
            'msg_count' => $msg_count
        ]);
    }
}
