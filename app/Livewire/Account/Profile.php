<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\WithFileUploads; 

use Auth;
use App\Models\User;

class Profile extends Component
{
    use WithFileUploads;

    public $avatar; 

    public function saveAvater(){
        if($this->avatar){
            $file = $this->avatar->storePublicly('vendor_avater', 'public');
            $vnd = Auth::user()->vendor;
            $vnd->avatar = $file;
            $vnd->save();
        }
        $this->avatar = null;
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.account.profile');
    }
}
