<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;
use App\Models\Message;

class Messages extends Component
{
    public $read_type;

    public function render(){
        $mesages = Message::query()
        ->where('vendor_id', Auth::user()->vendor_id)
        ->orWhere('user_id', Auth::user()->id)
        ->orderBy('created_at', 'DESC')
        ->whereNull('parent_id')
        ->get();

        return view('livewire.account.messages', [
            'mesages' => $mesages
        ]);
    }
}
