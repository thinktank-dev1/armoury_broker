<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset AS PassReset;
use Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Auth;

class PasswordReset extends Component
{
    public $email, $password, $token;

    public function mount(){
        $this->email = Request::input('email');
        $this->token = Request::input('token');
    }

    public function updatePass(){
        $this->validate([
            'email' => 'required',
            'password' => 'required',
            'token' => 'required'
        ]);

        $status = Password::reset(
            ['email' => $this->email, 'password' => $this->password, 'password_confirmation' => $this->password, 'token' => $this->token],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PassReset($user));
            }
        );
        if($status === Password::PASSWORD_RESET){
            $credentials = [
                'email' => $this->email,
                'password' => $this->password
            ];
            if(Auth::attempt($credentials)){
                return redirect()->intended('shop');
            }
        }
        else{
            if($status == "passwords.token"){
                $this->addError('status', "Invalid password reset token");
            }
            else{
                $this->addError('status', $status);
            }
        }
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.auth.password-reset');
    }
}
