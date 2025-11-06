<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Http\Request;
use Auth;

class VerifyEmail extends Component
{
    public $email;

    public function mount(){
        if(!Auth::guest()){
            $usr = Auth::user();
            if($usr){
                $this->email = $usr->email;
            }
        }
    }

    public function ResendEmail(){
        Auth::user()->sendEmailVerificationNotification();
        session()->flash('status', 'Email successfully sent.');
    }

    public function editEmail(){
        $this->validate([
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
        ]);
        $usr = Auth::user();
        $usr->email = $this->email;
        $usr->save();
        $this->dispatch('close-modal');
        $this->ResendEmail();
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.auth.verify-email');
    }
}
