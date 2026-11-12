<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Auth;
use App\Models\Product;
use App\Models\WishList;
use App\Models\OrderItem;
use App\Models\Vendor;
use App\Models\MessageThread;
use App\Models\Message;

class CartList extends Component
{
    // public $cart_items_model;
    public $cart_items_session = [];
    public $vendor = null;
    public $name, $surname, $email, $contact_number, $message;

    public function mount(){
    }

    public function saveMessage(){
        if(Auth::guest()){
            $rules = [
                'name' => 'required', 
                'surname' => 'required', 
                'email' => 'required', 
                'contact_number' => 'required',
                'message' => 'required',
            ];
        }
        else{
            $rules = [
                'message' => 'required'
            ];
        }
        $this->validate($rules);

        $thread = new MessageThread();
        $thread->user_1 = $this->vendor->user->id;
        if(Auth::user()){
            $thread->user_2 = Auth::user()->id;
        }
        $thread->name = $this->name;
        $thread->surname = $this->surname;
        $thread->email = $this->email;
        $thread->contact_number = $this->contact_number;
        $thread->save();
        
        $msg = new Message();
        $msg->message_thread_id = $thread->id;
        if(Auth::user()){
            $msg->user_id = Auth::user()->id;
        }
        $msg->message = $this->message;
        $msg->save();
        
        $this->dispatch('message-sent');
    }

    public function showMessageModal($id){
        $this->vendor = Vendor::find($id);
        $this->dispatch('show-message-modal');
    }

    public function removeItem($id){
        if(!Auth::guest()){
            $itm = OrderItem::where('user_id', Auth::user()->id)->where('id', $id)->first();
            if($itm){
                $itm->delete();
            }
        }
    }

    public function removeSessionItem($id){
        $cart = session()->get('cart');
        foreach($cart As $k => $ct){
            if($ct['product_id'] == $id){
                unset($cart[$k]);
                break;
            }
        }
        session()->forget('cart');
        session()->put('cart', $cart);
        return redirect('cart');
    }

    public function gotToCheckOut($id){
        $order_item = OrderItem::query()
        ->where('user_id', Auth::user()->id)
        ->whereNull('order_id')
        ->where('vendor_id', $id)
        ->get();

        $go = true;

        foreach($order_item AS $itm){
            if(!$itm->product->hasStock()){
                $go = false;
                break;
            }
        }
        if($go){
            return redirect('cart/'.$id);
        }
        else{
            $this->addError('error', 'Your cart has product(s) out of stock. Please remove item(s) before proceeding');
        }
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
                        $qty = $ct['quantity'];
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
