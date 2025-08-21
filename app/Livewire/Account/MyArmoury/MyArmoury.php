<?php

namespace App\Livewire\Account\MyArmoury;

use Livewire\Component;
use Livewire\WithPagination;

use Auth;

use App\Models\Product;
use App\Models\Vendor;

class MyArmoury extends Component
{
    use WithPagination;

    public function mount(){
        if(!Auth::user()->vendor_id){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
        }
    }

    public function copyLink(){
        if(Auth::user()->vendor){
            $link = url(Auth::user()->vendor->url_name);
            $this->link = $link;
            $this->dispatch('copy-link', link: $link);
        }
    }

    public function render(){
        $link = null;
        if(Auth::user()->vendor){
            $link = url(Auth::user()->vendor->url_name);
            $this->link = $link;
            $this->dispatch('copy-link', link: $link);
        }

        $vendor_id = null;
        $sold_count = 0;
        if(Auth::user()->vendor_id){
            $vendor_id = Auth::user()->vendor_id;
            $v = Vendor::find($vendor_id);
            foreach($v->orders->where('status', 'COMPLETE') AS $order){
                $sold_count += $order->items->count();
            }
        }

        $products = Product::query()
        ->where('user_id', Auth::user()->id)
        ->when($vendor_id, function($q)use($vendor_id){
            return $q->where('vendor_id', $vendor_id);
        })
        ->paginate(20);

        return view('livewire.account.my-armoury.my-armoury', [
            'link' => $link,
            'products' => $products,
            'sold_count' => $sold_count
        ]);
    }
}
