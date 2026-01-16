<?php

namespace App\Livewire\Account\Profile;

use Livewire\Component;

use Illuminate\Auth\Events\Registered;

use Auth;
use Hash;

class ProfileForm extends Component
{
    public $name, $surname, $mobile_number, $email, $password;
    public $show_password;

    public function mount(){
        $usr = Auth::user();
        $this->name = $usr->name;
        $this->surname = $usr->surname;
        $this->mobile_number = $usr->mobile_number;
        $this->email = $usr->email;

        $this->show_password = false;
    }

    public function togglePassword(){
        if($this->show_password){
            $this->show_password = false;
        }
        else{
            $this->show_password = true;
        }
    }

    public function saveUser(){
        $this->validate([
            'name' => 'required', 
            'surname' => 'required', 
            'mobile_number' => 'required|phone:ZA|unique:users,mobile_number,'.Auth::user()->id, 
            'email' => 'required|email|unique:users,email,'.Auth::user()->id, 
        ]);

        $usr = Auth::user();

        if($this->email != $usr->email){
            $usr->email_verified_at = null;
            Auth::user()->sendEmailVerificationNotification();
        }

        $usr->name = $this->name;
        $usr->surname = $this->surname;
        $usr->mobile_number = $this->mobile_number;
        $usr->email = $this->email;
        $usr->save();

        if($this->password){
            $usr->password = Hash::make($this->password);
            $usr->save();
        }
        session()->flash('status', 'Profile successfully updated.');
    }
    
    public function render(){
        return view('livewire.account.profile.profile-form');
    }
}
