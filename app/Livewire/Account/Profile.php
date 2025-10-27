<?php

namespace App\Livewire\Account;

use Livewire\Component; 

use Auth;
use App\Models\User;

class Profile extends Component
{

    public function render()
    {
        return view('livewire.account.profile');
    }
}
