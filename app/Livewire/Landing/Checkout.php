<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

use App\Lib\BobPay;
use App\Lib\PayFastApi;

use Auth;
use App\Models\OrderItem;
use App\Models\DeliverOption;
use App\Models\Setting;
use App\Models\Order;
use App\Models\Dealer;

class Checkout extends Component
{
    public $vendor_id, $order_id;
    public $shipping_tot, $service_fees, $cart_sub_total, $cart_total;
    public $cart = [];
    public $terms_and_conditions;
    public $payment_url;
    public $collection_free_shipping;
    public $delivery_option, $delivery_address;
    public $address; 

    public function mount($id, $order_id = null){
        if(!Auth::user()->vendor_id){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can proceed!');
        }

        $this->vendor_id = $id;
        if($order_id){
            $this->order_id = $order_id;
        }
        $this->payment_url = env('PAYFAST_SANDBOX_URL');
        $this->getCart();

        $this->address = Auth::user()->vendor->street."\n".Auth::user()->vendor->suburb."\n".Auth::user()->vendor->city."\n".Auth::user()->vendor->province."\n".Auth::user()->vendor->postal_code;
    }

    public function processPayment($type = null){
        $this->dispatch('go-to-top');
        $this->validate([
            'terms_and_conditions' => 'required'
        ],
        [
            'terms_and_conditions.required'=> "Please accept the Terms and Conditions"
        ]);

        $go = True;
        foreach($this->cart AS $ct){
            if(!$ct['deliver_collection']){
                $this->addError('error', "Please select collection/delivery for all items");
                return;
            }
            if($ct['deliver_collection'] == "seller delivery" || $ct['deliver_collection'] == "Courier"){
                if($ct['delivery_address'] == null){
                    $this->addError('error', 'Please enter delivery address for all items');
                    return;
                }
                if($ct['deliver_collection'] == "Courier"){
                    if($ct['shipping_id'] == null){
                        $this->addError('error',"Please select Courier for items that require it.");
                        return;
                    }
                }
                if($ct['deliver_collection'] == "Courier"){
                    if(!$ct['shipping_id']){
                        $this->addError('error', "Please select Courier for all items that need to be couriered");
                    }
                }
            }
            if($ct['deliver_collection'] == "dealer stock"){
                if(!$ct['dealer_option']){
                    $this->addError('error', 'Please select dealer options');
                }
            }
        }

        if($this->order_id){
            $order = Order::find($this->order_id);    
        }
        else{
            $order = new Order();
        }
        $order->user_id = Auth::user()->id;
        $order->vendor_id = $this->vendor_id;
        $order->cart_total = $this->cart_total;
        $order->fee = $this->service_fees;
        $order->total_shipping_fee = $this->shipping_tot;
        $order->save();

        $this->order_id = $order->id;
        
        foreach($this->cart AS $ct){
            $itm = OrderItem::find($ct['id']);
            if($itm){
                $itm->order_id = $order->id;
                $itm->collection_free_shipping = $ct['collection_free_shipping'];
                $itm->save();
            }
        }

        $data = [
            'user_first_name' => Auth::user()->name,
            'user_last_name' => Auth::user()->surname,
            'user_email' => Auth::user()->email,
            'user_cell_number' => Auth::user()->mobile_number,
            'payment_id' => $order->id,
            'amount' => $this->cart_total,
        ];

        $pf = new PayFastApi();
        $payload = $pf->setPayLoad($data);
        $payload = json_encode($payload);
        $this->dispatch('process-payment', data: $payload);
    }

    #[On('update-quantity')]
    public function updateQuantity($id,$qty){
        if($id){
            $itm = OrderItem::find($id);
            if($itm){
                $itm->quantity = $qty;
                $itm->save();
            }
        }
        $this->getCart();
    }

    public function updatedCart($v,$el){
        $arr = explode(".", $el);
        $itm = $this->cart[$arr[0]];
        $ord = OrderItem::find($itm['id']);
        if($ord){
            if($arr[1] == "shipping_id"){
                $del = DeliverOption::find($v);
                if($del){
                    $ord->shipping_id = $v;
                    $ord->shipping_price = $del->price;
                }
            }
            if($arr[1] == "deliver_collection"){
                $ord->deliver_collection = $v;
                if($v == "collection"){
                    $ord->delivery_address = null;
                    $ord->dealer_option = null;
                    $ord->ab_dealer_id = null;
                    $ord->custom_dealer_details = null;    
                }
                if($v == "buyer delivery" || $v == "Courier"){
                    $ord->dealer_option = null;
                    $ord->ab_dealer_id = null;
                    $ord->custom_dealer_details = null;
                    if(!$ord->delivery_address){
                        $ord->delivery_address = $this->address;
                    }
                }
                if($v == "dealer stock"){
                    $ord->delivery_address = null;
                }
            }
            if($arr[1] == "delivery_address"){
                $ord->delivery_address = $v;
            }
            if($arr[1] == "dealer_option"){
                $ord->dealer_option = $v;
                if($v == "ab dealer"){
                    $ord->custom_dealer_details = null;
                }
                if($v == "custom dealer"){
                    $ord->ab_dealer_id = null;
                }
            }
            if($arr[1] == "ab_dealer_id"){
                $ord->ab_dealer_id = $v;
            }
            if($arr[1] == "custom_dealer_details"){
                $ord->custom_dealer_details = $v;
            }
            $ord->save();
        }
        $this->getCart();
    }

    public function getCart(){
        $this->cart = [];
        $this->shipping_tot = 0;
        $this->service_fees = 0;
        $this->cart_sub_total = 0;
        $this->cart_total = 0;

        if(!$this->order_id){
            $cart = OrderItem::query()
            ->where('user_id', Auth::user()->id)
            ->where('vendor_id', $this->vendor_id)
            ->whereNull('order_id')
            ->get();
        }
        else{
            $cart = OrderItem::query()
            ->where('user_id', Auth::user()->id)
            ->where('vendor_id', $this->vendor_id)
            ->where('order_id', $this->order_id)
            ->get();
        }

        $stn = Setting::where('name', 'service_fee')->first();

        $cart_arr = [];
        foreach($cart AS $ct){
            $img = null;
            if($ct->product->images->count() > 0){
                $img = $ct->product->images->first()->image_url;
            }
            $tot = $ct->price * $ct->quantity;

            $total_fee_amount = ($stn->value/100) * $tot;
            $payable_fee = 0;
            
            if($ct->product->service_fee_payer == "50-50"){
                $payable_fee = (50/100) * $total_fee_amount;
            }
            elseif($ct->product->service_fee_payer == "buyer"){
                $payable_fee = $total_fee_amount;
            }
            
            $ct->service_fee = $payable_fee;
            $ct->save();

            $this->shipping_tot += $ct->shipping_price;
            $this->service_fees += $ct->service_fee;
            $this->cart_sub_total += $tot;

            $arr = [
                "id" => $ct->id,
                "oder_no" => str_pad($ct->id, 4, '0', STR_PAD_LEFT),
                "vendor_name" => $ct->product->vendor->name,
                "item_name" => $ct->product->item_name,
                "item_image" => $img,
                "qty" => $ct->quantity,
                "price" => $ct->price,
                "total" => $tot,
                "shipping_id" => $ct->shipping_id,
                "shipping_price" => $ct->shipping_price,
                "service_fee" => $ct->service_fee,
                "product" => $ct->product,
                "collection_free_shipping" => $ct->collection_free_shipping,

                "deliver_collection" => $ct->deliver_collection,
                "delivery_address" => !empty($ct->delivery_address) ? $ct->delivery_address : $this->address,
                "dealer_option" => $ct->dealer_option,
                "ab_dealer_id" => $ct->ab_dealer_id,
                "custom_dealer_details" => $ct->custom_dealer_details,
            ];
            $this->cart[] = $arr;
        }
        $this->cart_total = $this->shipping_tot + $this->service_fees + $this->cart_sub_total;
    }

    #[Layout('components.layouts.landing')] 
    public function render(){
        $dealers = Dealer::where('business_province', Auth::user()->vendor->province)->orderBy('business_name', 'ASC')->get();
        return view('livewire.landing.checkout', [
            'dealers' => $dealers
        ]);
    }
}
