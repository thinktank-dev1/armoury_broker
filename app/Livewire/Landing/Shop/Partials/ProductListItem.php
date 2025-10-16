<?php

namespace App\Livewire\Landing\Shop\Partials;

use Livewire\Component;

use Auth;
use App\Models\Product;
use App\Models\WishList;
use App\Models\OrderItem;

class ProductListItem extends Component
{
    public $product;
    public $tag;
    public $availability;

    public function mount($id){
        $this->product = Product::find($id);
        $qty = $this->product->quantity;
        $this->availability = true;
        
        $itms_count = OrderItem::query()
        ->where('product_id', $id)
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->sum('quantity');
        
        if($this->product->listing_type == "wanted"){
            $this->tag = "Wanted";
        }
        elseif($qty <= $itms_count){
            $this->tag = "Sold";
            $this->availability = false;
        }
        elseif ($this->product->created_at->gte(now()->subDays(30))) {
            $this->tag = "New";
        }
    }

    public function addToCart(){
        if(!Auth::guest()){
            $order_item = OrderItem::query()
            ->where('user_id', Auth::user()->id)
            ->where('product_id', $this->product->id)
            ->whereNull('order_id')
            ->first();

            $exist = false;
            if(!$order_item){
                $order_item = new OrderItem();
            }
            else{
                $exist = true;
            }
            $order_item->user_id = Auth::user()->id;
            $order_item->vendor_id = $this->product->vendor->id;
            $order_item->product_id = $this->product->id;
            $order_item->price = $this->product->item_price;
            if($exist){
                $qty = $order_item->quantity;
                $qty += 1;
            }
            else{
                $qty = 1;
            }
            $order_item->quantity = $qty;
            $order_item->save();
            $this->dispatch('added-to-cart');
        }
        else{
            $cart = session()->get('cart');
            if(!$cart){
                $cart = [
                    $this->product->id => [
                        'user_id' => session()->getId(),
                        'vendor_id' => $this->product->vendor->id,
                        'product_id' => $this->product->id,
                        'price' => $this->product->item_price,
                        'quantity' => 1,
                    ]
                ];
                session()->put('cart', $cart);
            }
            elseif(isset($cart[$this->product->id])){
                $cart[$this->product->id]['quantity']++;
                session()->put('cart', $cart);
            }
            else{
                $cart[$this->product->id] = [
                    'user_id' => session()->getId(),
                    'vendor_id' => $this->product->vendor->id,
                    'product_id' => $this->product->id,
                    'price' => $this->product->item_price,
                    'quantity' => 1,
                ];
                session()->put('cart', $cart);
            }
            $this->dispatch('added-to-cart');
        }
    }

    public function addToWishList($id){
        $wl = WishList::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
        if($wl){
            $wl->delete();
        }
        else{
            WishList::create([
                'user_id' => Auth::user()->id,
                'product_id' => $id
            ]);
        }
    }

    public function render(){
        return view('livewire.landing.shop.partials.product-list-item');
    }
}
