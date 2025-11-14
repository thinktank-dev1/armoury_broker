<?php

namespace App\Livewire\Landing\Shop\Partials;

use Livewire\Component;

use Auth;
use App\Models\VendorLike;
use App\Models\Vendor;

class LikedShops extends Component
{
    public $like_id;

    public function mount($id){
        $this->like_id = $id;
    }

    public function likeVendor($id){
        $lk = VendorLike::where('user_id', Auth::user()->id)->where('vendor_id', $id)->first();
        if($lk){
            $lk->delete();
        }
        else{
            VendorLike::create([
                'user_id' => Auth::user()->id,
                'vendor_id' => $this->vendor->id
            ]);
        }
    }

    public function render()
    {
        $shop = null;
        $liked_shop = VendorLike::find($this->like_id);
        if($liked_shop){
            $shop = Vendor::find($liked_shop->vendor_id);
        }

        return view('livewire.landing.shop.partials.liked-shops', [
            'shop' => $shop
        ]);
    }
}
