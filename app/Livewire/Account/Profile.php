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
            $file = $this->avatar->storePublicly('prifile_images', 'public');
            $usr = Auth::user();
            $usr->avatar = $file;
            $usr->save();
        }
        $this->avatar = null;
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.account.profile');
    }
}
