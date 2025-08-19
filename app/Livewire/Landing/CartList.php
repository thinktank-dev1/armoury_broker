<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Auth;
use App\Models\Product;
use App\Models\WishList;
use App\Models\OrderItem;

class CartList extends Component
{
    // public $cart_items_model;
    public $cart_items_session = [];

    public function mount(){
            
    }

    public function getCart(){
        if(!Auth::guest()){
            //Check If session has orders
            $cart = session()->get('cart');
            if($cart){
                foreach($cart AS $ct){
                    $order_item = OrderItem::query()
                    ->where('user_id', Auth::user()->id)
                    ->where('product_id', $ct['product_id'])
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
                    $order_item->vendor_id = $ct['vendor_id'];
                    $order_item->product_id = $ct['product_id'];
                    $order_item->price = $ct['price'];
                    if($exist){
                        $qty = $order_item->quantity;
                        $qty += 1;
                    }
                    else{
                        $qty = 1;
                    }
                    $order_item->quantity = $qty;
                    $order_item->save();
                }
                session()->forget('cart');
            }

            $order_item = OrderItem::query()
            ->where('user_id', Auth::user()->id)
            ->whereNull('order_id')
            ->get()
            ->groupBy('vendor_id');

            return $order_item;
        }
        else{
            $cart = session()->get('cart');
            if($cart){
                foreach($cart AS $ct){
                    $product = Product::find($ct['product_id']);
                    $arr = [
                        'product' => $product,
                        'cart_item' => $ct
                    ];
                    $this->cart_items_session[$ct['vendor_id']][] = $arr;
                }
            }
        }
    }

    #[Layout('components.layouts.landing')] 
    public function render(){
        $cart_items_model = [];
        $cart_items = $this->getCart();
        if($cart_items){
            $cart_items_model = $cart_items;
        }
        return view('livewire.landing.cart-list', [
            'cart_items_model' => $cart_items_model
        ]);
    }
}
