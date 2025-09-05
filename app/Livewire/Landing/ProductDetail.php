<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Auth;
use App\Models\Product;
use App\Models\WishList;
use App\Models\OrderItem;
use App\Models\ProductOffer;

class ProductDetail extends Component
{
    public $product;
    public $quantity;
    public $offer_amount;
    public $availability;

    public function mount($id){
        $this->product = Product::find($id);
        $qty = $this->product->quantity;

        $itms_count = OrderItem::query()
        ->where('product_id', $id)
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->sum('quantity');

        $this->quantity = $itms_count;
        
        if($qty <= $itms_count){
            $this->availability = false;
        }
        else{
            $this->availability = true;
        }
    }

    public function showOfferModal(){
        $this->offer_amount = $this->product->item_price;
        $this->dispatch('show-offer-modal');
    }

    public function saveOffer(){
        $this->validate([
            'offer_amount' => 'required'
        ]);
        $cur_price = $this->product->item_price;
        $allowed = $cur_price - ((20/100) * $cur_price);
        if($this->offer_amount < $allowed){
            $this->addError('error', 'Offer cannot be less than '.$allowed);
        }
        elseif(Auth::guest()){
            $this->addError('error', 'Please login to make an offer');
        }
        else{
            ProductOffer::create([
                'user_id' => Auth::user()->id,
                'vendor_id' => $this->product->vendor->id,
                'product_id' => $this->product->id,
                'offer_amount' => $this->offer_amount,
                'status' => 0,
            ]);
            $this->dispatch('offer-saved');
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
                $qty += $this->quantity;
            }
            else{
                $qty = $this->quantity;
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
                        'quantity' => $this->quantity,
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
                    'quantity' => $this->quantity,
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

    #[Layout('components.layouts.landing')]
    public function render(){
        $may_likes = Product::inRandomOrder()->take(8)->get();
        return view('livewire.landing.product-detail', [
            'may_likes' => $may_likes
        ]);
    }
}
