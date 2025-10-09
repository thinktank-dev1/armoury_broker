<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Auth;
use App\Models\User;

class Login extends Component
{
    public $email, $password;

    public function mount(){
        if(!Auth::guest()){
            if(!Auth::user()->vendor_id){
                return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
            }
            return redirect('shop');
        }
    }

    public function logInUser(){
        $this->validate([
            'email' => 'required|email', 
            'password' =>'required'
        ]);

        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];
        if(Auth::attempt($credentials)){
            $usr = Auth::user();
            if($usr->status != 1){
                Auth::logout();
                $this->addError('user', 'Your account is inactive.');
            }
            return redirect()->intended(route('shop'));
        }
        else{
            $this->addError('user', 'Invalid email or password.');
        }
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.auth.login');
    }
}
