<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

use App\Lib\BobPay;
use App\Lib\PayFastApi;
use App\Lib\Communication;

use Auth;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\DeliverOption;
use App\Models\Setting;
use App\Models\Order;
use App\Models\Dealer;
use App\Models\PromoCode;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Models\VendorPromoCode;
use App\Models\OfferPrice;

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
    public $voucher_code, $voucher_discount_amount, $voucher_code_id, $voucher_error;
    public $total; 
    public $has_vendor_promo_codes;
    public $vendor_promo_code, $vendor_promo_code_id,$vendor_promo_type,$vendor_promo_value, $vendor_promo_amount, $vendor_promo_code_error;
    public $pay_with_wallet, $show_wallet_options;
    public $credit_payment, $gift_voucher_payment;
    public $credit_error, $gf_error;

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

        $this->address = Auth::user()->vendor->suburb."\n".Auth::user()->vendor->city."\n".Auth::user()->vendor->province."\n";

        $this->has_vendor_promo_codes = false;
        $vnd = Vendor::find($this->vendor_id);
        if($vnd){
            $cds = VendorPromoCode::where('vendor_id', $this->vendor_id)->where('status', 1)->where('deleted', 0)->count();
            if($cds > 0){
                $this->has_vendor_promo_codes = true;
            }
        }
    }

    public function updatedGiftVoucherPayment(){
        $gf = Auth::user()->vendor->giftVoucherBalance();
        if($this->gift_voucher_payment > $gf){
            $this->gift_voucher_payment = $gf;
            $this->gf_error = "Your maximum git voucher balance is ".$gf;
        }
        else{
            $this->gf_error = null;
        }
    }

    public function updatedCreditPayment(){
        $this->credit_payment = str_replace(' ', '', str_replace(',', '', $this->credit_payment));
        $credit = Auth::user()->vendor->withdrawableBalance();
        if($this->credit_payment > $credit){
            $this->credit_payment = $credit;
            $this->credit_error = "Your maximum credit is ".$credit;
        }
        else{
            $this->credit_error = null;
        }
    }

    public function updatedPayWithWallet(){
        if($this->pay_with_wallet){
            $this->show_wallet_options = true;
        }
        else{
            $this->show_wallet_options = false;
        }
    }

    public function updatedVendorPromoCode(){
        $this->vendor_promo_code_error = null;
        if($this->vendor_promo_code){
            $cd = VendorPromoCode::where('code', $this->vendor_promo_code)->where('vendor_id', $this->vendor_id)->where('status', 1)->where('deleted', 0)->first();
            if($cd){
                $this->vendor_promo_code_id = $cd->id;
                $this->vendor_promo_type = $cd->type;
                $this->vendor_promo_value = $cd->value;
            }
            else{
                $this->vendor_promo_code_error = "Invalid promo code";
                $this->vendor_promo_code = null;
                $this->vendor_promo_code_id = null;
                $this->vendor_promo_type = null;
                $this->vendor_promo_value = null;
                $this->vendor_promo_amount = null;
            }
        }
        else{
            $this->vendor_promo_code = null;
            $this->vendor_promo_code_id = null;
            $this->vendor_promo_type = null;
            $this->vendor_promo_value = null;
            $this->vendor_promo_amount = null;
            $this->vendor_promo_code_error = null;
        }
        $this->getCart();
    }

    public function updatedVoucherCode(){
        $this->voucher_error = null;
        if($this->voucher_code){
            $code = PromoCode::where('code', $this->voucher_code)->where('status', 0)->first();
            if($code){
                $this->voucher_code_id = $code->id;
                $this->voucher_discount_amount = $code->amount;
                $this->getCart();
            }
            else{
                $this->voucher_error = "Invalid voucher code";
            }
        }
        else{
            $this->voucher_code = null;
            $this->voucher_discount_amount = null;
            $this->voucher_code_id = null;
            $this->voucher_error = null;
        }
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
            if(!$ct['shipping_method']){
                $this->addError('error', "Please select shipping method for all items");
                return;
            }
            if($ct['shipping_method'] == "dealer_stock"){
                if(!$ct['dealer_option']){
                    $this->addError('error', 'Please select dealer options');
                }
                if($ct['dealer_option'] == "ab dealer"){
                    if(!$ct['ab_dealer_id']){
                        $this->addError('error', 'Please select ab dealer options');
                        return;
                    }
                }
                if($ct['dealer_option'] == "custom dealer"){
                    if(!$ct['custom_dealer_details']){
                        $this->addError('error', 'Please select enter dealer details');
                        return;
                    }
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
                $itm->shipping_method = $ct['shipping_method'];

                $itm->save();
            }
        }

        $do_payment = true;
        if($this->voucher_code_id){
            $code = PromoCode::where('code', $this->voucher_code)->where('status', 0)->first();
            if($code){
                $code_amount = $code->amount;
                $discount = $code_amount;
                if($code_amount >= $this->cart_total){
                    $do_payment = False;
                    $discount = $this->cart_total;
                    
                    $balance = $amount - $this->cart_total;
                    if($balance > 0){
                        Transaction::create([
                            'name' => 'gift_voucher_credit',
                            'transaction_type' => 'voucher_balance',
                            'user_id' => Auth::user()->id,
                            'vendor_id' => Auth::user()->vendor_id,
                            'direction' => 'in',
                            'amount' => $balance,
                            'code' => $code->code,
                            'payment_status' => 'COMPLETE',
                            'release' => 1,
                        ]);
                    }
                    foreach($order->items AS $item){
                        $fee_rate = 5;
                        $min_fee = 25;
                        $stn_fee = Setting::where('name', 'service_fee')->first();
                        $stn_min_fee = Setting::where('name', 'min_fee_amount')->first();
                        if($stn_fee){
                            $fee_rate = $stn_fee->value;
                        }
                        if($stn_min_fee){
                            $min_fee = $stn_min_fee->value;
                        }

                        $item_amount = $item->price * $item->quantity;

                        $prdt = $item->product;
                        if($prdt->service_fee_payer == "buyer"){
                            $fee = ($fee_rate / 100) * $item_amount;
                            if($fee < $min_fee){
                                $fee = $min_fee;
                            }
                            $usr = User::find($order->user_id);
                            Transaction::create([
                                'name' => 'service_fee',
                                'transaction_type' => 'service_fee',
                                'user_id' => $usr->id,
                                'vendor_id' => $usr->vendor_id,
                                'direction' => 'out',
                                'amount' => $fee,
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'code' => '',
                                'payment_status' => 'COMPLETE',
                                'release' => null,
                            ]);
                        }
                        elseif($prdt->service_fee_payer == "seller"){
                            $fee = ($fee_rate / 100) * $item_amount;
                            if($fee < $min_fee){
                                $fee = $min_fee;
                            }
                            $item_amount -= $fee;
                            $usr = User::where('vendor_id', $item->vendor_id)->first();
                            Transaction::create([
                                'name' => 'service_fee',
                                'transaction_type' => 'service_fee',
                                'user_id' => $usr->id,
                                'vendor_id' => $usr->vendor_id,
                                'direction' => 'out',
                                'amount' => $fee,
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'code' => '',
                                'payment_status' => 'COMPLETE',
                                'release' => null,
                            ]);
                        }
                        elseif($prdt->service_fee_payer == "50-50"){
                            $fee = ($fee_rate / 100) * $item_amount;
                            if($fee < $min_fee){
                                $fee = $min_fee;
                            }
                            $fee = $fee / 2;
                            $item_amount -= $fee;

                            $vnd = User::where('vendor_id', $item->vendor_id)->first();
                            Transaction::create([
                                'name' => 'service_fee',
                                'transaction_type' => 'service_fee',
                                'user_id' => $vnd->id,
                                'vendor_id' => $vnd->vendor_id,
                                'direction' => 'out',
                                'amount' => $fee,
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'code' => '',
                                'payment_status' => 'COMPLETE',
                                'release' => null,
                            ]);
                            $usr = User::find($order->user_id);
                            Transaction::create([
                                'name' => 'service_fee',
                                'transaction_type' => 'service_fee',
                                'user_id' => $usr->id,
                                'vendor_id' => $usr->vendor_id,
                                'direction' => 'out',
                                'amount' => $fee,
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'code' => '',
                                'payment_status' => 'COMPLETE',
                                'release' => null,
                            ]);
                        }

                        $item_amount += $item->shipping_fee;

                        Transaction::create([
                            'name' => 'order_payment',
                            'transaction_type' => 'voucher_payment',
                            'user_id' => $order->user_id,
                            'vendor_id' => $item->vendor_id,
                            'direction' => 'in',
                            'amount' => $item_amount,
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'payment_status' => 'COMPLETE',
                        ]);

                        $offer = OfferPrice::where('user_id', $order->user_id)->where('product_id', $item->product_id)->whereNull('status')->first();
                        if($offer){
                            $offer->status = 1;
                            $offer->save();
                        }
                    }
                    $this->sendComm($order->id);

                    $order->amount_paid = 0;
                    $order->status = "COMPLETE";
                    $order->save();

                    session()->flash('status', 'Purchase successfully completed.');
                }
                else{
                    $payment_amount = $this->cart_total - $code_amount;
                    $this->cart_total = $payment_amount;
                }
                $order->promo_code_id = $code->id;
                $order->discount_amount = $discount;
                $order->promo_code = $code->code;

                $order->g_payment_id = $code->code;
                $order->short_reference = "Voucher discount";
                $order->save();

                $code->status = 1;
                $code->save();
            }
        }

        if($this->vendor_promo_code_id){
            $cd = VendorPromoCode::find($this->vendor_promo_code_id);
            if($cd->status == 1 && $cd->deleted == 0){
                $order->vendor_promo_code = $cd->code;
                $order->save();
                
                if($cd->type == "value"){
                    $this->vendor_promo_amount = $cd->value;
                }
                elseif($cd->type == "percentage"){
                    $this->vendor_promo_amount = ($cd->value / 100) * $this->cart_total;
                }
                $this->cart_total = $this->cart_total - $this->vendor_promo_amount;
            }
        }

        $partial = False;
        if($this->pay_with_wallet){
            if($this->credit_payment){
                foreach($order->items AS $item){
                    Transaction::create([
                        'name' => 'order_payment',
                        'transaction_type' => 'wallet_payment',
                        'user_id' => Auth::user()->id,
                        'vendor_id' => $order->vendor_id,
                        'direction' => 'in',
                        'amount' => $this->credit_payment,
                        'order_id' => $order->id,
                        'order_item_id' => $item->id,
                        'payment_status' => 'COMPLETE',
                    ]);
                    $this->cart_total -= $this->credit_payment;
                    $order->g_payment_id = rand(100000,999999);
                    $order->status = 'COMPLETE';
                    $order->amount_paid = $this->credit_payment;
                    $order->save();
                }
                return redirect('pf-payment/11/pending');
            }
            if($this->cart_total > 0){
                if($this->gift_voucher_payment && $this->cart_total >= $this->gift_voucher_payment){
                    Transaction::create([
                        'name' => 'order_payment',
                        'transaction_type' => 'gift_voucher_payment',
                        'user_id' => Auth::user()->id,
                        'vendor_id' => $order->vendor_id,
                        'direction' => 'in',
                        'amount' => $this->gift_voucher_payment,
                        'order_id' => $order->id,
                        'payment_status' => 'Partial Payment',
                    ]);
                    $this->cart_total -= $this->credit_payment;
                    $partial = True;
                }
            }
            if($this->cart_total <= 0){
                $do_payment = False;
                session()->flash('status', 'Purchase successfully completed.');
            }
        }

        if($do_payment){
            $data = [
                'user_first_name' => Auth::user()->name,
                'user_last_name' => Auth::user()->surname,
                'user_email' => Auth::user()->email,
                'user_cell_number' => Auth::user()->mobile_number,
                'payment_id' => $order->id,
                'amount' => $this->cart_total,
            ];
            if($partial){
                $data['custom_str1'] = 'partial';
            }

            $pf = new PayFastApi();
            $payload = $pf->setPayLoad($data);
            $payload = json_encode($payload);
            $this->dispatch('process-payment', data: $payload);
        }
    }

    #[On('update-quantity')]
    public function updateQuantity($id,$qty){
        if($qty < 1){
            $qty = 1;
        }
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
            if($arr[1] == "shipping_method"){
                $ord->shipping_method = $v;
                $del = DeliverOption::where('product_id', $ord->product_id)->where('type', $v)->first();
                $ord->shipping_price = $del->price;

                if($v != "dealer_stock"){
                    $ord->dealer_option = null;
                    $ord->ab_dealer_id = null;
                    $ord->custom_dealer_details = null;
                }
                else{
                    $prdt = $itm['product'];
                    if($prdt->dealer_stocking_type == 'custom_dealer'){
                        $ord->dealer_option = 'custom dealer';
                        $ord->custom_dealer_details = $prdt->private_dealer_details;
                        $ord->ab_dealer_id = null;
                    }
                    else{
                        $ord->dealer_option = 'ab dealer';
                        $ord->ab_dealer_id = $prdt->dealer_id;  
                        $ord->custom_dealer_details = null; 
                    }
                }
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
            elseif($ct->product->service_fee_payer == "seller"){
                $payable_fee = 0;
            }
            
            $ct->service_fee = $payable_fee;
            $ct->save();

            $this->shipping_tot += $ct->shipping_price;
            $this->service_fees += $ct->service_fee;
            $this->cart_sub_total += $tot;

            $dealer = null;
            if($ct->ab_dealer_id){
                $dealer = Dealer::find($ct->ab_dealer_id);
            }

            $arr = [
                "id" => $ct->id,
                "oder_no" => str_pad($ct->id, 4, '0', STR_PAD_LEFT),
                "vendor_name" => $ct->product->vendor->name,
                "item_name" => $ct->product->item_name,
                "item_image" => $img,
                "qty" => $ct->quantity,
                "tot_qty" => $ct->product->quantity,
                "price" => $ct->price,
                "total" => $tot,

                "shipping_method" => $ct->shipping_method,
                
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
                "dealer" => $dealer,
            ];
            $this->cart[] = $arr;
        }

        $fee_rate = 5;
        $min_fee = 25;
        $stn_fee = Setting::where('name', 'service_fee')->first();
        $stn_min_fee = Setting::where('name', 'min_fee_amount')->first();
        if($stn_fee){
            $fee_rate = $stn_fee->value;
        }
        if($stn_min_fee){
            $min_fee = $stn_min_fee->value;
        }
        /*
        if($this->service_fees < $min_fee){
            $this->service_fees = $min_fee;
        }
        */


        $this->cart_total = $this->shipping_tot + $this->service_fees + $this->cart_sub_total;
        $this->total = $this->cart_total;

        if($this->voucher_discount_amount){
            if($this->voucher_discount_amount > $this->cart_total){
                $this->total = 0;
            }
            else{
                $this->total = $this->cart_total - $this->voucher_discount_amount;
            }
        }

        if($this->vendor_promo_code_id){
            $cd = VendorPromoCode::find($this->vendor_promo_code_id);
            if($cd->status == 1 && $cd->deleted == 0){
                if($cd->type == "value"){
                    $this->vendor_promo_amount = $cd->value;
                }
                elseif($cd->type == "percentage"){
                    $this->vendor_promo_amount = ($cd->value / 100) * $this->cart_total;
                }
                $this->total = $this->total - $this->vendor_promo_amount;
            }
        }
    }

    #[Layout('components.layouts.landing')] 
    public function render(){
        $dealers = Dealer::where('province', Auth::user()->vendor->province)->orderBy('business_name', 'ASC')->get();
        return view('livewire.landing.checkout', [
            'dealers' => $dealers
        ]);
    }

    public function sendComm($id){
        $order = Order::find($id);
        if($order){
            $comm = new Communication();    
            $user = User::find($order->user_id);
            if($user){
                $data = [
                    'name' => $user->name,
                    'to' => $user->email,
                    'subject' => 'Armoury Broker Payment Received',
                    'message_body' => "
                        Your payment for order <b>#".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</b> was successfully completed.<br />
                        Amount Paid: <b>R".number_format($order->amount_paid,2)."</b><br /><br />
                        The Vendor will begin arranging collection / delivery of your product. 
                    "
                ];
                $comm->sendMail($data);
            }

            $vendor = Vendor::find($order->vendor_id);
            $order_data = "<table class='table-bodered'>";
            $order_data .= "<thead><tr><th style='text-align: left'>Item</th><th style='text-align: left'>Qty</th><th style='text-align: left'>Price</th></tr>";
            foreach($order->items AS $item){
                $order_data .= "<tr>";
                $order_data .= "<td>".$item->product->item_name."</td>";
                $order_data .= "<td>".$item->quantity."</td>";
                $order_data .= "<td>R".number_format($item->price,2)."</td>";
                $order_data .= "</tr>";
            }
            $order_data .= "</table>";

            if($vendor){
                $data = [
                    'name' => $vendor->user->name,
                    'to' => $vendor->user->email,
                    'subject' => 'Armoury Broker - New Order',
                    'message_body' => "
                        <b>You have a new order from armoury broker.</b><br />
                        ".$order_data."<br /><br />
                        Please <a href='".url('login')."'>login</a> to get order details and start the order delivery or collection process. 
                    "
                ];
                $comm->sendMail($data);
            }
        }
    }
}
