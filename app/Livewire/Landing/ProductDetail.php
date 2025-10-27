<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Lib\Communication;

use Auth;
use App\Models\Product;
use App\Models\WishList;
use App\Models\OrderItem;
use App\Models\ProductOffer;

use App\Models\Message;
use App\Models\MessageThread;

class ProductDetail extends Component
{
    public $product;
    public $quantity;
    public $offer_amount;
    public $availability;
    public $qty;

    public function mount($id){
        $this->product = Product::find($id);
        $qty = $this->product->quantity;
        $this->qty = $qty;

        $itms_count = OrderItem::query()
        ->where('product_id', $id)
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->sum('quantity');

        if($itms_count > 0){
            $this->quantity = $itms_count;
        }
        else{
            $this->quantity = 1;
        }
        
        if($qty <= $itms_count){
            $this->availability = false;
        }
        else{
            $this->availability = true;
        }
    }

    public function updatedQuantity(){
        if($this->quantity > $this->qty){
            $this->quantity = $this->qty;
        }
    }

    public function contactBuyer(){
        $tr = MessageThread::where('user_1', Auth::user()->id)->where('user_2', $this->product->user->id)->where('product_id', $this->product->id)->first();
        if(!$tr){
            $tr = new MessageThread();
            $tr->user_1 = Auth::user()->id;
            $tr->user_2 = $this->product->user->id;
            $tr->product_id = $this->product->id;
            $tr->save();
        }
        return redirect('messages/'.$tr->id);
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
            $thread = new MessageThread();
            $thread->user_1 = $this->product->vendor->user->id;
            $thread->user_2 = Auth::user()->id;
            $thread->product_id = $this->product->id;
            $thread->save();

            $msg = new Message();
            $msg->message_thread_id = $thread->id;
            $msg->user_id = Auth::user()->id;
            $msg->message = "You have a new offer";
            $msg->offer_amount = $this->offer_amount;
            $msg->save();

            $order_data = "<table class='table-bodered' style='width: 100%'>";
            $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>Offer Details</th></tr></thead>";
            $order_data .= "<tbody>";
            $order_data .= "<tr>";

            if($this->product->images->count() > 0){
                $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$this->product->images->first()->image_url)."'></td>";
            }
            else{
                $order_data .= "<td></td>";
            }
            $order_data .= "<td>";
            $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
            $order_data .= "<tr><td>Item Name:</td><td>".$this->product->item_name."</td></tr>";
            $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($this->product->item_price,2)."</td></tr>";
            $order_data .= "<tr><td>Offered Price:</td><td>R ".number_format($this->offer_amount,2)."</td></tr>";
            $order_data .= "</table>";
            $order_data .= "</td>";

            $order_data .= "</tr>";
            $order_data .= "</tbody>";
            $order_data .= "</table>";


            $body = "Awesome news!<br /><br />
            Someone has made an offer on one of the items that you have listed in your armoury.<br />".$order_data;

            $after = "<b>Next step:</b><br />
            Remember that you can Accept, Reject, or Counter the offer that has been made for an item.<br /><br > 
            Click on the “View Offer” button above to view and respond in the message section.";

            $user = $this->product->vendor->user;
            $data = [
                'to' => $user->email,
                'name' => $user->name,
                'subject' => 'New Offer',
                'title' => "New Offer",
                'message_body' => $body,
                'cta' => true,
                'cta_text' => 'View Offer',
                'cta_url' => url('messages/'.$thread->id),
                'after_cta_body' => $after,
            ];
            $comm = new Communication();
            $comm->sendMail($data);

            $this->dispatch('offer-saved');
        }
    }

    public function addToCart(){
        dd($this->quantity,$this->qty);
        if($this->quantity > $this->qty){
            $this->dispatch('quantity-error');
            return;
        }
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
