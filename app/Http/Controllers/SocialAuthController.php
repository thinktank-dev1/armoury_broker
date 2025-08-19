<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Models\User;

class SocialAuthController extends Controller
{
    public function socialLogin($social){
        return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallback($social){
        $userSocial = Socialite::driver($social)->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();
        if($user){
            Auth::login($user);
            return redirect('dashboard');
        }
        else{
            return redirect('auth/register?name='.$userSocial->getName().'email='.$userSocial->getEmail());
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
