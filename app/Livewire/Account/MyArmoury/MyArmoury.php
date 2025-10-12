<?php

namespace App\Livewire\Account\MyArmoury;

use Livewire\Component;
use Livewire\WithPagination;

use Auth;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Brand;

class MyArmoury extends Component
{
    use WithPagination;

    public $share_link;
    public $listing_type, $category_id, $brand_id, $sold;

    public function mount(){
        if(!Auth::user()->vendor_id){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
        }
        $this->share_link = url(Auth::user()->vendor->url_name);
        $this->sold = False;
    }

    public function changeListingTypeFilter($type){
        $this->listing_type = $type;
        if($this->sold){
            $this->sold = false;
        }
    }

    public function toggleSoldFilter(){
        $this->sold = !$this->sold;
        if($this->sold){
            $this->listing_type = null;
        }
    }

    public function clearFilters(){
        $this->listing_type = null; 
        $this->category_id = null;
        $this->brand_id = null;
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
            //$this->dispatch('copy-link', link: $link);
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

        $listing_type = $this->listing_type; 
        $category_id = $this->category_id; 
        $brand_id = $this->brand_id;
        $sold = $this->sold;

        $products = Product::query()
        ->where('user_id', Auth::user()->id)
        ->when($vendor_id, function($q)use($vendor_id){
            return $q->where('vendor_id', $vendor_id);
        })
        ->when($listing_type, function($q) use($listing_type){
            return $q->where('listing_type', $listing_type);
        })
        ->when($category_id, function($q) use($category_id){
            return $q->where('category_id', $category_id);
        })
        ->when($brand_id, function($q) use($brand_id){
            return $q->where('brand_id', $brand_id);
        })
        ->when($sold, function($q){
            return $q->whereHas('orders');
        })
        ->paginate(20);

        $cats = Category::orderBy('category_name', 'ASC')->get();
        $brands = Brand::orderBy('brand_name', 'ASC')->get();

        return view('livewire.account.my-armoury.my-armoury', [
            'link' => $link,
            'products' => $products,
            'sold_count' => $sold_count,
            'cats' => $cats,
            'brands' => $brands
        ]);
    }
}
