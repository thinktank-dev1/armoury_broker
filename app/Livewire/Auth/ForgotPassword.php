<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Component
{
    public $email;

    public function sendLink(){
        $this->validate([
            'email' => 'required'
        ]);
        $user = User::where('email', $this->email)->first();
        if(!$user){
            $this->addError("error", "We can't find a user with the provided email address");
        }
        else{
            $token = Password::getRepository()->create($user);
            $user->sendPasswordResetNotification($token);
            session()->flash('message', 'We have sent a reset password link to your email.');
        }
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.auth.forgot-password');
    }
}
