<?php

namespace App\Livewire\Account\Admin;

use Livewire\Component;

use App\Models\Dispute;

class Disputes extends Component
{
    public function setResolved($id){
        $dsp = Dispute::find($id);
        if($dsp){
            $dsp->user_1_status = 1;
            $dsp->user_2_status = 1;
            $dsp->save();
        }
    }
    public function render(){
        $dsps = Dispute::query()
        ->whereNull('user_1_status')
        ->orWhere('user_1_status', 0)
        ->orwhereNull('user_2_status')
        ->orWhere('user_2_status', 0)
        ->get();

        return view('livewire.account.admin.disputes', [
            'dsps' => $dsps
        ]);
    }
}
