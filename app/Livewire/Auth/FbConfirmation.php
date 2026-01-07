<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\DeleteConfirmation;

class FbConfirmation extends Component
{
    public $token;
    public function mount($token){
        $this->token = $token;
    }

    public function render(){
        $status = DeleteConfirmation::where('token', $this->token)->first();
        return view('livewire.auth.fb-confirmation', [
            'status' => $status,
        ]);
    }
}
