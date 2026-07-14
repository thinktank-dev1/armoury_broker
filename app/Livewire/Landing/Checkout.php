<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

use App\Lib\BobPay;
use App\Lib\PayFastApi;
use App\Lib\Communication;
use App\Lib\WalletDocApi;
use App\Lib\PudoApi;
use App\Lib\SharedFunctions;

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
use App\Models\CreditPayment;
use App\Models\OrderDeliveryAddress;

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
    public $payment_method, $card_fee_stnt, $id_number;
    public $payment_id;
    public $provinces = [];
    public $drop_off_point, $show_courier_fields;
    public $terminal_id, $street, $local_area, $suburb, $city, $postal_code, $province, $type, $longitude, $latitude;
    public $show_payment_section;
    public $show_wallet_doc_options;
    public $direct_eft_type, $digital_wallet_type;
    public $wallet_doc_pub, $wallet_doc_trx_id, $wallet_doc_client_key;
    public $pudo_terminal;

    public function mount($id, $order_id = null){
        if(!Auth::user()->vendor_id){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can proceed!');
        }

        $this->vendor_id = $id;
        if($order_id){
            $this->order_id = $order_id;
        }
        $this->payment_url = env('PAYFAST_SANDBOX_URL');
        $this->show_courier_fields = false;
        $this->show_payment_section = true;
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
        $card_fee_stnt = Setting::where('name', 'card_fee')->first();
        $this->card_fee_stnt = $card_fee_stnt->value;

        $this->provinces = [
            'EC' => 'Eastern Cape',
            'FS' => 'Free State',
            'GP' => 'Gauteng',
            'KZN' => 'KwaZulu-Natal',
            'LP' => 'Limpopo',
            'MP' => 'Mpumalanga',
            'NW' => 'North West',
            'NC' => 'Northern Cape',
            'WC' => 'Western Cape'
        ];
        $this->drop_off_point = 'door';
        
        $this->updatePaymentMethodDisplay();
    }

    public function updatedDropOffPoint(){
        if($this->drop_off_point == "locker"){
            $api = new PudoApi();
            $res = $api->getTerminals();
            if($res){
                return collect($res);
            }
        }
        return false;
    }

    public function getCoord(){
        if($this->street && $this->local_area && $this->suburb && $this->city && $this->postal_code && $this->province){
            $add = $this->street .', '. $this->local_area .', '. $this->suburb .', '. $this->city .', '. $this->postal_code .', '. $this->province.', South Africa';

            $lib = new SharedFunctions();
            $res = $lib->getCoordinatesFree($add);
            if($res){
                $this->latitude = $res['lat'];
                $this->longitude = $res['lon'];
            }
        }
    }

    public function updatedStreet(){
        $this->getCoord();
    }
    public function updatedLocalArea(){
        $this->getCoord();
    }
    public function updatedSuburb(){
        $this->getCoord();
    }
    public function updatedCity(){
        $this->getCoord();
    }
    public function updatedPostalCode(){
        $this->getCoord();
    }
    public function updatedProvince(){
        $this->getCoord();
    }

    public function setDeliveryAddress(){
        $this->dispatch('go-to-top');
        $rules = [
            'drop_off_point' => "required",
        ];
        if($this->drop_off_point == "locker"){
            $rules["terminal_id"] = "required";
        }
        if($this->drop_off_point == "door"){
            $rules["street"] = "required"; 
            $rules["local_area"] = "required";
            $rules["suburb"] = "required";
            $rules["city"] = "required";
            $rules["postal_code"] = "required";
            $rules["province"] = "required";
            $rules["type"] = "required";
            $rules["longitude"] = "required";
            $rules["latitude"] = "required";
        }
        $this->validate($rules);

        foreach($this->cart AS $ct){
            if($ct['shipping_method'] == "courier"){
                $vnd_det = $ct['product']->courierDetails;
                $pick_up_type = null;
                $collection_address = [];

                $delivery_type = null;
                $delivery_address = [];

                $parcels = [
                    "submitted_length_cm" => $vnd_det->length_cm,
                    "submitted_width_cm" => $vnd_det->width_cm,
                    "submitted_height_cm" => $vnd_det->height_cm,
                    "submitted_weight_kg" => $vnd_det->weight_kg,
                    "parcel_description" => $ct['product']->item_description,
                    "alternative_tracking_reference" => "AB-ORD".str_pad($this->order_id, 4, '0', STR_PAD_LEFT),
                ];

                if($vnd_det->terminal_id){
                    $pick_up_type = "locker";
                    $collection_address = [
                        'terminal_id' => $vnd_det->terminal_id,
                    ];
                }
                else{
                    $pick_up_type = "door";
                    $collection_address = [
                        "type" => $vnd_det->type,
                        "entered_address" => $vnd_det->street.', '.$vnd_det->local_area.', '.$vnd_det->suburb.', '.$vnd_det->city.', '.$vnd_det->postal_code,
                        "company" => $ct['product']->vendor->name,
                        "street_address" => $vnd_det->street,
                        "local_area" => $vnd_det->local_area,
                        "code" => $vnd_det->postal_code,
                        "city" => $vnd_det->city,
                        "zone" => $vnd_det->province,
                        "country" => "South Africa",
                        "lat" => $vnd_det->latitude,
                        "lng" => $vnd_det->longitude,
                    ];
                }

                if($this->drop_off_point == "locker"){
                    $delivery_type = "locker";
                    $delivery_address = [
                        "terminal_id" => $this->terminal_id,
                    ];
                }
                else{
                    $delivery_type = "door";
                    $delivery_address = [
                        "type" => "business",
                        "entered_address" => $this->street.', '.$this->local_area.', '.$this->suburb.', '.$this->city.', '.$this->postal_code,
                        "company" => Auth::user()->vendor->name,
                        "street_address" => $this->street,
                        "local_area" => $this->local_area,
                        "code" => $this->postal_code,
                        "city" => $this->city,
                        "zone" => $this->province,
                        "country" => "South Africa",
                        "lat" => $this->latitude,
                        "lng" => $this->longitude,
                    ];
                }
                $pudo = new PudoApi();
                $rates = $pudo->getRate($pick_up_type,$delivery_type,$collection_address, $delivery_address, $parcels);
                $add = null;
                if($rates){
                    if(is_array($rates)){
                        if(isset($rates['rate'])){
                            $rate = $rates['rate'];
                            $this->shipping_tot = $rate;
                            $prdt = $ct['product'];
                            
                            $ord_itm = OrderItem::find($ct['id']);
                            $add = $this->saveDeliveryAddress($ord_itm->id);

                            $ord_itm->shipping_price = $rate;
                            $ord_itm->order_delivery_address_id = $add->id;
                            $ord_itm->save();   
                        }
                    }
                }
                else{
                    $this->addError('error', $rates);
                    return;
                }
            }
        }
        $this->getCart();
        $this->show_payment_section = true;
    }

    public function saveDeliveryAddress($order_item_id){
        $itm = OrderItem::find($order_item_id);
        if($itm){
            if($itm->order_delivery_address_id){
                $add = OrderDeliveryAddress::find($itm->order_delivery_address_id);
            }
            else{
                $add = new OrderDeliveryAddress();
            }

            if($this->drop_off_point == "locker"){
                $add->terminal_id = $this->terminal_id;
                $add->street = null; 
                $add->local_area = null;
                $add->suburb = null;
                $add->city = null;
                $add->postal_code = null;
                $add->province = null;
                $add->type = null;
                $add->longitude = null;
                $add->latitude = null;
            }
            elseif($this->drop_off_point == "door"){
                $add->terminal_id = null;
                $add->street = $this->street; 
                $add->local_area = $this->local_area;
                $add->suburb = $this->suburb;
                $add->city = $this->city;
                $add->postal_code = $this->postal_code;
                $add->province = $this->province;
                $add->type = $this->type;
                $add->longitude = $this->longitude;
                $add->latitude = $this->latitude;
            }
            $add->save();
            return $add;
        }
        return false;
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
        $this->credit_error = null;
        $this->credit_payment = str_replace(' ', '', str_replace(',', '', $this->credit_payment));
        $credit = Auth::user()->vendor->withdrawableBalance();
        if($this->credit_payment > $credit){
            $this->credit_payment = $credit;
            $this->credit_error = "Your maximum credit is ".$credit;
            // return;
        }
        if($this->credit_payment > $this->total){
            $this->credit_payment = $this->total;
            $this->credit_error = "You have entered an amount greater than cart total";
            // return;
        }
        $this->updatePaymentMethodDisplay();
    }

    public function updatedPayWithWallet(){
        if($this->pay_with_wallet){
            $this->show_wallet_options = true;
        }
        else{
            $this->show_wallet_options = false;
            $this->credit_payment = null;
        }
        $this->updatePaymentMethodDisplay();
    }

    public function updatedPaymentMethod(){
        $this->updatePaymentMethodDisplay();

        if($this->credit_payment){
            if($this->credit_payment == $this->total){
                $this->payment_method = null;
            }
        }
        elseif(!$this->credit_payment){
            $this->show_wallet_options = false;
        }
    }

    public function updatePaymentMethodDisplay(){
        $this->show_wallet_doc_options = true;

        if(!Auth::user()->vendor->withdrawableBalance()){
            $this->pay_with_wallet = false;
            $this->credit_payment = null;
            $this->show_wallet_options = false;
        }
        if($this->pay_with_wallet){
            if($this->credit_payment){
                if($this->credit_payment == $this->total){
                    $this->show_wallet_doc_options = false;
                    $this->show_wallet_options = true;
                    $this->payment_method = null;
                }
                else{
                    $this->show_wallet_doc_options = true;
                }
            }
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
                if($code->status == 1){
                    $this->voucher_code_id = $code->id;
                    $this->voucher_discount_amount = $code->amount;
                    $this->getCart();
                }
                else{
                    $this->voucher_error = "Invalid voucher code";
                }
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

        $rules = [
            'terms_and_conditions' => 'required'
        ];
        if($this->payment_method == "direct_eft"){
            $rules['direct_eft_type'] = 'required';
        }
        if($this->payment_method == "digital_wallet"){
            $rules['digital_wallet_type'] = 'required';
        }

        $this->validate($rules,
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

        if($this->credit_payment > $this->total){
            $this->addError('error', 'The amount you entered is above cart total');
            return;
        }

        if($this->order_id){
            $order = Order::find($this->order_id);    
        }
        else{
            $order = new Order();
        }
        $order->user_id = Auth::user()->id;
        $order->vendor_id = $this->vendor_id;
        $order->cart_total = $this->total;
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

        if($this->vendor_promo_code_id){
            $code = VendorPromoCode::find($this->vendor_promo_code_id);
            if($code){
                $order->discount_amount = $this->voucher_discount_amount;
                $order->vendor_promo_code = $this->vendor_promo_code;
                $order->save();
            }
        }

        $do_payment = true;
        $payable_amount = $this->total;
        if($this->credit_payment){
            if($this->credit_payment == $this->total){
                $this->createTransactions();
                $do_payment = false;

                $order->g_payment_id = substr(bin2hex(random_bytes(3)), 0, 8);;
                $order->amount_paid = $this->credit_payment;
                $order->status = 'COMPLETE';
                $order->save();

                return redirect('pf-payment/'.$order->id.'/complete');
            }
            else{
                CreditPayment::create([
                    'user_id' => Auth::user()->id,
                    'vendor_id' => $this->vendor_id,
                    'order_id' => $order->id,
                    'amount' => $this->credit_payment,
                    'order_status' => 0,
                ]);
                $do_payment = true;
                $payable_amount -= $this->credit_payment; 
            }   
        }

        if($do_payment){
            $order_no = 'AB-ORD-'.str_pad($order->id, 4, '0', STR_PAD_LEFT);
            if($this->payment_method == "card" || $this->payment_method == "digital_wallet"){
                $stn = Setting::where('name', 'card_fee')->first();
                if($stn){
                    $card_fee_stnt = $stn->value;
                    $fee = ($card_fee_stnt/100) * $payable_amount;
                    $payable_amount += $fee;
                }
            }

            $method = 'card';
            if($this->payment_method == "eft"){
                $method = "bank2bank";
            }
            if($this->payment_method == "direct_eft"){
                $method = $this->direct_eft_type;
            }

            $doc = new WalletDocApi();

            $doc_customer_id = Auth::user()->vendor->wallet_doc_customer_id;
            if(!$doc_customer_id){
                $usr = Auth::user();
                $data = [
                    'first_name' => $usr->name,
                    'last_name' => $usr->surname,
                    'email' => $usr->email,
                ];
                $res = $doc->createCustomer($data);
                if($res){
                    $usr->vendor->wallet_doc_customer_id = $res['customer_id'];
                    $usr->vendor->save();
                }
            }

            $data = [
                'amount' => $payable_amount * 100,
                'currency' => 'ZAR',
                'customer_id' => $doc_customer_id,
                'capture' => false,
                'reference' => $order_no,
                'statement_descriptor' => $order_no,
                'payment_method' => $method,
                
                'return_url' => url('payment-complete'),
            ];
            if($method == "capitec_pay"){
                $data['mobile_number'] = Auth::user()->mobile_number;
            }
            if($this->payment_method == "digital_wallet"){
                $data['digital_wallet'] = $this->digital_wallet_type;
            }

            $transaction = $doc->genPayment($data);

            if(!$transaction){
                $this->addError('error', "Failed to create transaction");
            }
            else{
                $order->uuid = $transaction['id'];
                $order->save();

                // $trx_id = $transaction['id'];
                // $client_key = $transaction['client_key'];
                /*
                $trx_data = [
                    'client_key' => $client_key,
                    'capture_amount' => $payable_amount * 100,
                ];
                */

                // $trx_res = $doc->processTransaction($transaction['id'],$trx_data);
                // dd($transaction,$trx_res);

                $payment_id = $transaction['redirect']['id'];
                $url = $transaction['redirect']['redirect_url'];
                $this->dispatch('send-to-payment', id:$payment_id, url:$url);
            }
        }
    }

    public function createTransactions(){
        $vnd = null;
        $order = null;
        foreach($this->cart AS $item){
            $vnd = $item['product']->vendor;
            $product = $item['product'];
            $order_item = OrderItem::find($item['id']);
            $order = Order::find($order_item->order_id);

            $fee = (float)$item['service_fee'];
            if($fee > 0){
                Transaction::create([
                    'name' => 'service_fee',
                    'transaction_type' => 'service_fee',
                    'user_id' => Auth::user()->id,
                    'vendor_id' => Auth::user()->vendor_id,
                    'direction' => 'out',
                    'amount' => $fee,
                    'order_id' => $order->id,
                    'order_item_id' => $order_item->id,
                    'code' => '',
                    'payment_status' => 'COMPLETE',
                    'release' => null,
                ]);
            }
            $vendor_fee = 0;
            if($product->service_fee_payer == "50-50"){
                $vendor_fee = $fee;
            }
            elseif($product->service_fee_payer == "seller"){
                $stn = Setting::where('name', 'service_fee')->first();
                $stn_min = Setting::where('name', 'min_fee_amount')->first();

                $fee_per = $stn->value;
                $vendor_fee = ($fee_per/100) * $product->item_price;

                if($vendor_fee < $stn_min->value){
                    $vendor_fee = $stn_min->value;
                }
            }
            if($vendor_fee){
                $vendor_fee = number_format($vendor_fee,2);
                $vendor_fee = str_replace(' ', '', $vendor_fee);
                $vendor_fee = str_replace(',','.',$vendor_fee);

                Transaction::create([
                    'name' => 'service_fee',
                    'transaction_type' => 'service_fee',
                    'user_id' => $vnd->user->id,
                    'vendor_id' => $vnd->id,
                    'direction' => 'out',
                    'amount' => $vendor_fee,
                    'order_id' => $order->id,
                    'order_item_id' => $order_item->id,
                    'code' => '',
                    'payment_status' => 'COMPLETE',
                    'release' => null,
                ]);
            }

            $amount = $item['price'];
            if($vendor_fee){
                $amount -= $vendor_fee;
            }
            
            Transaction::create([
                'name' => 'order_payment',
                'transaction_type' => 'wallet_credit_payment',
                'user_id' => $vnd->user->id,
                'vendor_id' => $vnd->id,
                'direction' => 'in',
                'amount' => $amount,
                'order_id' => $order->id,
                'order_item_id' => $order_item->id,
                'payment_status' => 'COMPLETE',
            ]);

            $usr = Auth::user();
            $buyer_paid = $item['total'] - $item['service_fee'];
            Transaction::create([
                'name' => 'order_payment',
                'transaction_type' => 'wallet_credit_payment',
                'user_id' => $usr->id,
                'vendor_id' => $usr->vendor_id,
                'direction' => 'out',
                'amount' => $buyer_paid,
                'order_id' => $order->id,
                'order_item_id' => null,
                'payment_status' => 'COMPLETE',
            ]);
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
                //$ord->shipping_price = $del->price;

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
        $this->total = 0;

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
            // dd($cart,Auth::user()->id,$this->vendor_id,$this->order_id);

            $add = OrderDeliveryAddress::where('order_id', $this->order_id)->first();
            if($add){
                $this->terminal_id = $add->terminal_id;
                $this->street = $add->street;
                $this->local_area = $add->local_area;
                $this->suburb = $add->suburb;
                $this->city = $add->city;
                $this->postal_code = $add->postal_code; 
                $this->province = $add->province;
                $this->type = $add->type;
                $this->logitude = $add->logitude;
                $this->latitude = $add->latitude;

                $this->show_payment_section = true;
            }
        }

        $stn = Setting::where('name', 'service_fee')->first();

        $cart_arr = [];

        $dicount_value = null;
        $dicount_type = null;
        $discount_amount = 0;
        if($this->vendor_promo_code_id){
            $code = VendorPromoCode::find($this->vendor_promo_code_id);
            if($code->status == 1){
                $dicount_type = $code->type;
                $dicount_value = $code->value;
            }
        }
        // dd($cart);
        foreach($cart AS $ct){
            $img = null;
            if($ct->product->images->count() > 0){
                $img = $ct->product->images->first()->image_url;
            }

            $tot = $ct->price * $ct->quantity;
            $fee = 0;
            $price = $ct->price;
            $discount = 0;
            if($dicount_type){
                if($dicount_type == "percentage"){
                    $discount = ($dicount_value/100) * $tot;
                    $tot -= $discount;
                }
                elseif($dicount_type == "value"){
                    $discount = $dicount_value;
                    $tot -= $dicount_value;
                }
                $this->voucher_discount_amount += $discount;
            }
            $this->cart_sub_total += $tot;

            $min_fee_stn = Setting::where('name', 'min_fee_amount')->first();
            $min_fee_amount = $min_fee_stn->value;

            if($ct->product->service_fee_payer == "buyer"){
                $fee = ($stn->value / 100) * $tot;
                if($fee < $min_fee_amount){
                    $fee = $min_fee_amount;
                }
            }
            elseif($ct->product->service_fee_payer == "50-50"){
                $tot_fee = ($stn->value / 100) * $tot;
                if($tot_fee < $min_fee_amount){
                    $tot_fee = $min_fee_amount;
                }
                $fee = $tot_fee / 2;
            }
            $tot += $fee;

            if($ct->shipping_method == "courier"){
                $tot += $ct->shipping_price;
                $this->shipping_tot += $ct->shipping_price;
                $this->cart_total += $ct->shipping_price; 
            }

            $ct->service_fee = $fee;
            $ct->listed_price = $ct->product->item_price;
            $ct->price = $price;
            $ct->total_paid = $tot;
            $ct->discount = $discount;
            $ct->save();

            $this->service_fees += $fee;
            $this->cart_total += $tot;
            $this->total += $tot;

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
            if($ct->shipping_method == "courier"){
                $this->show_courier_fields = true;
                $this->show_payment_section = false;

                if($ct->order_delivery_address_id){
                    $add = OrderDeliveryAddress::find($ct->order_delivery_address_id);
                    if($add){
                        $this->terminal_id = $add->terminal_id;
                        $this->street = $add->street; 
                        $this->local_area = $add->local_area;
                        $this->suburb = $add->suburb;
                        $this->city = $add->city;
                        $this->postal_code = $add->postal_code;
                        $this->province = $add->province;
                        $this->type = $add->type;
                        $this->longitude = $add->longitude;
                        $this->latitude = $add->latitude;
                    }
                }
            }
            $this->cart[] = $arr;
        }
    }

    public $terminal_province, $locality, $sublocality;

    public function updatedTerminalProvince(){
        $this->locality = null; 
        $this->sublocality = null;
    }
    public function updatedLocality(){
        $this->sublocality = null;
    }
    public function updatedSublocality(){}

    #[Layout('components.layouts.landing')] 
    public function render(){
        $dealers = Dealer::where('province', Auth::user()->vendor->province)->orderBy('business_name', 'ASC')->get();

        $lockers = $this->updatedDropOffPoint();
        
        $lc_provinces = null;
        $localities = null;
        $sublocalities = null;
        $filteredLockers = null;
        
        if($lockers){
            if($this->terminal_province){
                $pr_arr = $this->provinceAliases($this->terminal_province);
                
                $localities = $lockers
                ->whereIn('detailed_address.province', $pr_arr)
                ->pluck('detailed_address.locality')
                ->unique()
                ->sort()
                ->values();

                $localities->sort();
            }
            if($this->locality){
                $sublocalities = $lockers
                ->whereIn('detailed_address.province', $pr_arr)
                ->where('detailed_address.locality', $this->locality)
                ->pluck('detailed_address.sublocality')
                ->unique()
                ->sort()
                ->values();

                $sublocalities->sort();
            }
            else{
                $sublocalities = null;
            }
            if($this->sublocality){
                $filteredLockers = $lockers
                ->whereIn('detailed_address.province', $pr_arr)
                ->where('detailed_address.locality', $this->locality)
                ->where('detailed_address.sublocality', $this->sublocality)
                ->values();
            }
            else{
                $filteredLockers = null;
            }
        }

        return view('livewire.landing.checkout', [
            'dealers' => $dealers,
            'localities' => $localities,
            'sublocalities' => $sublocalities,
            'filteredLockers' => $filteredLockers,
        ]);
    }

    public function provinceAliases($pr){
        if($pr == "Eastern Cape"){
            return ['EC', 'Eastern Cape'];
        }
        if($pr == "Free State"){
            return ['FS', 'Free State'];
        }
        if($pr == "Gauteng"){
            return ["Gauteng", "GP"];
        }
        if($pr == "KwaZulu-Natal"){
            return ["KZN", "KwaZulu-Natal"];
        }
        if($pr == "Limpopo"){
            return ["LM", "Limpopo"];
        }
        if($pr == "Mpumalanga"){
            return ["MP", "Mpumalanga"];
        }
        if($pr == "North West"){
            return ["NW", "North West"];
        }
        if($pr == "Northern Cape"){
            return ["NC", "Northern Cape"];
        }
        if($pr == "Western Cape"){
            return ["WC", "Western Cape"];
        }
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
