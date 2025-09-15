<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Illuminate\Auth\Events\Registered;

use Auth;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Message;

class Register extends Component
{
    public $name, $surname, $mobile_number, $email, $password, $terms_and_condotions;
    public function RegisterUser(){
        $this->validate([
            'name' => "required", 
            'surname' => "required",
            'mobile_number' => "required|phone:ZA|unique:users,mobile_number",
            'email' => "required|email|unique:users,email", 
            'password' => "required",
            'terms_and_condotions' => 'required',
        ],
        [
            'terms_and_condotions.required' => "You need to agree to the platform's T&Cs to proceed with your profile creation",
            'mobile_number.phone' => "Please enter a valid mobile number",

        ]);

        $role = Role::where('name', 'user')->first();
        if($role){
            $user = User::create([
                'role_id' => $role->id,
                'name' => $this->name,
                'surname' => $this->surname,
                'mobile_number' => $this->mobile_number,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'status' => 1,
            ]);

            event(new Registered($user));
            
            $credentials = [
                'email' => $this->email,
                'password' => $this->password
            ];
            if(Auth::attempt($credentials)){
                $usr = Auth::user();
                return redirect()->intended(route('dashboard'));
            }
            else{
                $this->addError('user', 'Invalid email or password.');
            }
        }
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.auth.register');
    }
}
