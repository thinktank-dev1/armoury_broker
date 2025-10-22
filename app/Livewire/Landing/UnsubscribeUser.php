<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

use App\Lib\Communication;
use App\Models\User;
use App\Models\Unsubscribe;

class UnsubscribeUser extends Component
{
    public $payload;

    public function mount($token){
        $comm = new Communication();
        try {
            $encrypted = $comm->base64url_decode($token);
            $json = Crypt::decryptString($encrypted);
            $payload = json_decode($json, true);

            if(isset($payload['id'])){
                $usr = User::find($payload['id']);
                if($usr){
                    $this->payload = $payload;
                }
            }
        } 
        catch (\Exception $e){
            abort(403, 'Invalid or expired token.');
        }
    }

    public function do_unsubscribe(){
        $usr = User::find($this->payload['id']);
        if($usr){
            if(!Unsubscribe::where('email', $usr->email)->first()){
                Unsubscribe::create([
                    'user_id' => $usr->id,
                    'email' => $usr->email,
                ]);
            }
            session()->flash('status', 'You have been successfully unsubscribed to all marketing emails.');
        }
        else{
            $this->addError('error', 'We cant find your account');
        }
    }

    public function render()
    {
        return view('livewire.landing.unsubscribe-user');
    }
}
