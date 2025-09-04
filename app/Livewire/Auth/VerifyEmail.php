<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Http\Request;
use Auth;

class VerifyEmail extends Component
{
    public function ResendEmail(){
        Auth::user()->sendEmailVerificationNotification();
        session()->flash('status', 'Email successfully sent.');
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.auth.verify-email');
    }
}
