<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\WithFileUploads;

use Auth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class Dashboard extends Component
{
    use WithFileUploads;

    public $avatar;
    public $share_link;

    public function mount(){
        if(!Auth::user()->vendor_id && Auth::user()->role->name != "admin"){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
        }
        if(Auth::user()->vendor){
            $this->share_link = url(Auth::user()->vendor->url_name);
        }
    }

    public function copyLink(){
        if(Auth::user()->vendor){
            $link = url(Auth::user()->vendor->url_name);
            $this->link = $link;
            $this->dispatch('copy-link', link: $link);
        }
    }

    public function saveAvater(){
        if($this->avatar){
            $file = $this->avatar->storePublicly('vendor_avater', 'public');
            $vnd = Auth::user()->vendor;
            $vnd->avatar = $file;
            $vnd->save();
        }
        $this->avatar = null;
        $this->dispatch('close-modal');
    }

    public function render(){
        $ab_credit = 0;
        $gf_voucher = 0;
        $wd_funds = 0;
        $ord_progress = 0;
        $tot_balance = 0;

        return view('livewire.account.dashboard', [
            'ab_credit' => $ab_credit,
            'gf_voucher' => $gf_voucher,
            'wd_funds' => $wd_funds,
            'ord_progress' => $ord_progress,
            'tot_balance' => $tot_balance,
        ]);
    }
}
