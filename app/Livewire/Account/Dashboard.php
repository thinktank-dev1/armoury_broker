<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;

class Dashboard extends Component
{
    public function mount(){
        if(!Auth::user()->vendor_id){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
        }
    }

    public function render(){
        return view('livewire.account.dashboard');
    }
}
