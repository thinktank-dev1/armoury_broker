<?php

namespace App\Livewire\Account\Admin\Dealers;

use Livewire\Component;

use Auth;
use App\Models\Dealer;
use App\Models\Vendor;

class ViewDealer extends Component
{
    public $cur_id;

    public function mount($id){
        $this->cur_id = $id;
    }

    public function changeStatus($status){
        $dl = Dealer::find($this->cur_id);
        if($dl){
            $dl->status = $status;
            $dl->save();
        }
    }

    public function render(){
        $dealer = Dealer::find($this->cur_id);
        $vendor = null;
        if($dealer->user){
            $vendor = Vendor::find($dealer->user->vendor_id);
        }

        return view('livewire.account.admin.dealers.view-dealer', [
            "vendor" => $vendor,
            "dealer" => $dealer
        ]);
    }
}
