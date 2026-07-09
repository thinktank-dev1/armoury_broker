<div>
    <div class="section py-5 bg-grey" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="row">
                        <div class="col-md-12">
                            <a class="text-dark-blue" href="{{ URL::previous() }}" wire:ignore>
                                <i class="fas fa-chevron-left"></i> &nbsp;&nbsp;Back
                            </a>
                        </div>
                        <div class="col-md-12 mt-4 mx-3 mx-md-0">
                            <h2 class="page-title">Cart</h2>
                        </div>
                        @if($errors->any())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (session('status'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-12 mt-3 p-3">
                            <b>Cart Items</b>
                            <div class="shop_cart_table mt-3">
                                <div class="accordion" id="accordion_checkout">
                                    @foreach($cart AS $k=>$item)
                                        @php
                                        $i = $loop->index;
                                        $xpanded = "false";
                                        $collapsed = "collapsed";
                                        $show = "";
                                        if($i == 0){
                                            $xpanded = "true";
                                            $show = "show";
                                            $collapsed = "";
                                        }
                                        $product = $item['product'];
                                        @endphp
                                        <div class="accordion-item mb-2">
                                            <h2 class="accordion-header" id="heading_{{ $item['id'] }}" wire:ignore.self>
                                                <button class="accordion-button {{ $collapsed }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $item['id'] }}" aria-expanded="{{ $xpanded }}" aria-controls="collapse_{{ $item['id'] }}" wire:ignore.self>
                                                    {{ $product->item_name }}
                                                </button>
                                            </h2>
                                            <div id="collapse_{{ $item['id'] }}" class="faq accordion-collapse collapse {{ $show }}" aria-labelledby="heading_{{ $item['id'] }}" data-bs-parent="#accordion__checkout" wire:ignore.self>
                                                <div class="accordion-body" style="background-color: #FFF;">
                                                    <div class="row">
                                                        <ul class="list-group">
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Item Name</small>
                                                                <span class="ms-auto"><a href="{{ url('shop/product/'.$product->id) }}"><b>{{ ucwords($product->item_name) }}</b></a></span>
                                                            </li>
                                                            @if($product->model_number)
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Model</small>
                                                                <span class="ms-auto"><b>{{ $product->model_number }}</b></span>
                                                            </li>
                                                            @endif
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Vendor</small>
                                                                <span class="ms-auto"><a href="{{ url('/'.$product->vendor->url_name) }}"><b>{{ ucwords($item['vendor_name']) }}</b></a></span>
                                                            </li>
                                                            <li class="list-group-item d-flex">
                                                                <small>Quantity</small>
                                                                <div class="ms-auto">
                                                                    <div class="quantity">
                                                                        <input type="button" value="-" class="minus">
                                                                        <input type="text" name="quantity" value="{{ $item['qty'] }}" title="Qty" class="qty" data-id="{{ $item['id'] }}" size="4" max="{{ $item['tot_qty'] }}">
                                                                        <input type="button" value="+" class="plus">
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Item Price</small>
                                                                <span class="ms-auto"><b>R {{ number_format($item['price'], 2) }}</b></span>
                                                            </li>
                                                            @if($item['shipping_price'])
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Shipping Price</small>
                                                                <span class="ms-auto"><b>R {{ number_format($item['shipping_price'], 2) }}</b></span>
                                                            </li>
                                                            @endif
                                                            @if($item['service_fee'])
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Service Fee</small>
                                                                <span class="ms-auto"><b>R {{ number_format($item['service_fee'], 2) }}</b></span>
                                                            </li>
                                                            @endif
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Total</small>
                                                                <span class="ms-auto"><b>R {{ number_format($item['total'], 2) }}</b></span>
                                                            </li>
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Delivery / Collection</small>
                                                                <div class="ms-auto">
                                                                    <div class="">
                                                                        @foreach($product->shippingOptions AS $ship)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" id="shipping_method_{{ $ship->id }}" value="{{ $ship->type }}" name="shipping_method_{{ $ship->id }}" wire:model.live="cart.{{ $k }}.shipping_method">
                                                                            <label class="form-check-label" for="shipping_method_{{ $ship->id }}">
                                                                                @if($ship->type == "collection_delivery")
                                                                                    {{ ucwords(str_replace('_', ' / ',$ship->type)) }}
                                                                                @else
                                                                                    {{ ucwords(str_replace('_', ' ',$ship->type)) }}
                                                                                @endif
                                                                            </label>
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            @if($item['shipping_method'] == "dealer_stock")
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Dealers</small>
                                                                <span class="ms-auto">
                                                                    @if($item['dealer_option'] == "ab dealer")
                                                                        {{ $item['dealer']->business_name }}<br />
                                                                        {{ $item['dealer']->province }}<br />
                                                                        R {{ number_format($item['dealer']->dealer_stocking_fee,2) }} pm<br />
                                                                    @elseif($item['dealer_option'] == "custom dealer")
                                                                        {{ $item['custom_dealer_details'] }}
                                                                    @endif
                                                                </span>
                                                            </li>
                                                            @endif

                                                            @if($item['deliver_collection'] == "Courier")
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Courier</small>
                                                                <span class="ms-auto">
                                                                    <div class="">
                                                                        <select class="form-control" name="courier_shipping" wire:model.live="cart.{{ $k }}.shipping_id">
                                                                            <option value="">Select Option</option>
                                                                            @foreach($product->shippingOptions AS $sh)
                                                                            <option value="{{ $sh->id }}">{{ $sh->type.'(R'.$sh->price.')' }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </span>
                                                            </li>
                                                            @endif
                                                            @if($item['deliver_collection'] == "collection")
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Collection Address</small>
                                                                <span class="ms-auto"><b>{{ $product->collection_address }}</b></span>
                                                            </li>
                                                            @endif
                                                            <li class="list-group-item">
                                                                <small style="font-size: 13px;"><b style="font-weight: 500;">Platform Fee Selected By Seller:</b> {{ ucwords($item['product']->service_fee_payer) }}</small>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if($show_courier_fields)
                            <div class="row mt-3">
                                <div class="col-md-12 mb-2">
                                    <b>Delivery Address</b>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label"><b>Drop Off Point</b></label>
                                    <div class="form-check form-check-inline ms-3">
                                        <input class="form-check-input" type="radio" name="drop_off_point" id="door" value="door" wire:model.live="drop_off_point">
                                        <label class="form-check-label" for="door">Door</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="drop_off_point" id="locker" value="locker" wire:model.live="drop_off_point">
                                        <label class="form-check-label" for="locker">Locker</label>
                                    </div>
                                </div>
                                @if($drop_off_point == "locker")
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <input type="text" class="form-control" placeholder="Terminal ID" name="terminal_id" wire:model.defer="terminal_id">
                                    </div>
                                </div>
                                @elseif($drop_off_point == "door")
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <input type="text" class="form-control" placeholder="Street" name="street" wire:model.defer="street">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Local Area" name="local_area" wire:model.defer="local_area">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <input type="text" class="form-control" placeholder="Suburb" name="suburb" wire:model.defer="suburb">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <input type="text" class="form-control" placeholder="City" name="city" wire:model.defer="city">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <input type="text" class="form-control" placeholder="Postal Code" name="postal_code" wire:model.defer="postal_code">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <select class="form-control" name="province" wire:model.defer="province">
                                            <option value="">Select Province</option>
                                            @foreach($provinces AS $k => $pr)
                                            <option value="{{ $k }}">{{ $pr }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <select class="form-control" name="type" wire:model.blur="type">
                                            <option value="">Select Address Type</option>
                                            <option value="residential">Residential</option>
                                            <option value="business">Business</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <input type="text" class="form-control" placeholder="Longitude" name="longitude" wire:model.defer="longitude">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <input type="text" class="form-control" placeholder="Latitude" name="latitude" wire:model.defer="latitude">
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12 text-center">
                                    <a href="#" class="btn btn btn-secondary" wire:click.prevent="setDeliveryAddress">NEXT</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($show_payment_section)
    <div class="section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <h2 class="page-title pb-0 mb-0">Platform Fees</h2>
                            <p><small><b>Please Note: </b>Armoury Broker allows the fee to be covered by either the buyer or the seller or split between the parties on a 50-50 basis.</small></p>
                        </div>
                        
                        @if($has_vendor_promo_codes)
                        <div class="row">
                            <div class="col-md-6 mt-4 mb-4">
                                <h2 class="page-title pb-0 mb-0">Apply Promo Code</h2>
                                <div class="mb-3">
                                    <label class="form-label">Enter Promo Code</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" aria-describedby="promo_help_text" name="vendor_promo_code" wire:model.blur="vendor_promo_code">
                                        <button class="btn btn-outline-secondary" type="button">Apply</button>
                                    </div>
                                    <div id="promo_help_text" class="form-text text-danger">
                                        @if($vendor_promo_code_error)
                                        {{ $vendor_promo_code_error }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <h2 class="page-title pb-0 mb-0">Payment Method</h2>
                                    </div>
                                </div>
                                <div class="col-md-12 border-bottom py-2">
                                    <b class="payment-title">WALLET</b>
                                </div>
                                <div class="col-md-12 border-bottom">
                                    @php
                                    $disabled = false;
                                    if(!Auth::user()->vendor->withdrawableBalance()){
                                        $disabled = true;
                                    }
                                    @endphp
                                    <div class="d-flex align-items-center py-2">
                                        <div class="payment-sel">
                                            <input class="form-check-input" type="checkbox" id="pay_with_wallet" wire:model.live="pay_with_wallet" @if($disabled) disabled @endif >
                                        </div>
                                        <div class="payment-type-text ms-3">
                                            <p class="m-0 p-0 @if($disabled) text-muted @endif">Pay with your Armoury Broker Wallet</p>
                                            <p class="m-0 p-0 text-muted"><i>This can be the full or partial value</i></p>
                                        </div>
                                        <div class="payment-logos">
                                            <b @if($disabled) class="text-muted" @endif>R {{ number_format(Auth::user()->vendor->withdrawableBalance(),2) }}</b>
                                            <p class="m-0 p-0 @if($disabled) text-muted @endif">Available for shopping</p>
                                        </div>
                                    </div>
                                    @if($show_wallet_options)
                                    <div class="mt-3">
                                        @if(Auth::user()->vendor->withdrawableBalance() > 0)
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">R</span>
                                                    <input type="text" class="form-control" name="credit_payment" wire:model.live="credit_payment">
                                                </div>
                                                @if($credit_error)
                                                <div id="emailHelp" class="form-text text-danger">{{ $credit_error }}</div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12 border-bottom py-2">
                                    <b class="payment-title">OTHER OPTIONS</b>
                                </div>
                                @php
                                $prefix = "c";
                                if(!$show_wallet_doc_options){
                                    $prefix = "g";    
                                }
                                @endphp
                                <div class="col-md-12 border-bottom">
                                    <div class="d-flex align-items-center py-2">
                                        <div class="payment-sel">
                                            <input class="form-check-input" type="radio" name="payment_method" value="eft" wire:model.live="payment_method" @if($prefix == "g") disabled @endif >
                                        </div>
                                        <div class="payment-type-text ms-3">
                                            <p class="m-0 p-0 @if($prefix == 'g') text-muted @endif">Pay with instant EFT</p>
                                        </div>
                                        <div class="payment-logos">
                                            <div class="d-flex">
                                                <img src="{{ asset('img/payment/'.$prefix.'/eft.png') }}" class="payment-logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 border-bottom">
                                    <div class="d-flex align-items-center py-2">
                                        <div class="payment-sel">
                                            <input class="form-check-input" type="radio" name="payment_method" value="direct_eft" wire:model.live="payment_method" @if($prefix == "g") disabled @endif >
                                        </div>
                                        <div class="payment-type-text ms-3">
                                            <p class="m-0 p-0 @if($prefix == 'g') text-muted @endif">Pay with direct bank EFT</p>
                                        </div>
                                        <div class="payment-logos">
                                            <div class="d-flex">
                                                <img src="{{ asset('img/payment/'.$prefix.'/absa_pay.png') }}" class="payment-logo">
                                                <img src="{{ asset('img/payment/'.$prefix.'/capitec_pay.png') }}" class="payment-logo">
                                                <img src="{{ asset('img/payment/'.$prefix.'/nedbank.png') }}" class="payment-logo">
                                            </div>
                                        </div>
                                    </div>
                                    @if($payment_method == "direct_eft")
                                    <div class="text-end">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="direct_eft_type" id="absa_pay" value="absa_pay" wire:model.defer="direct_eft_type">
                                            <label class="form-check-label" for="absa_pay">ABSA Pay</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="direct_eft_type" id="capitec_pay" value="capitec_pay" wire:model.defer="direct_eft_type">
                                            <label class="form-check-label" for="capitec_pay">Capitec Pay</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="direct_eft_type" id="nedbank_eft" value="nedbank_eft" wire:model.defer="direct_eft_type">
                                            <label class="form-check-label" for="nedbank_eft">Nedbank FFT</label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12 border-bottom">
                                    <div class="d-flex align-items-center py-2">
                                        <div class="payment-sel">
                                            <input class="form-check-input" type="radio" name="payment_method" value="card" wire:model.live="payment_method" @if($prefix == "g") disabled @endif >
                                        </div>
                                        <div class="payment-type-text ms-3">
                                            <p class="m-0 p-0 @if($prefix == 'g') text-muted @endif">Pay with credit/debit card</p>
                                            <p class="m-0 p-0 text-muted"><i>Connivance fee: 1% of the total value of the transaction</i></p>
                                        </div>
                                        <div class="payment-logos">
                                            <div class="d-flex">
                                                <img src="{{ asset('img/payment/'.$prefix.'/visa.png') }}" class="payment-logo">
                                                <img src="{{ asset('img/payment/'.$prefix.'/mastercard.png') }}" class="payment-logo">
                                                <img src="{{ asset('img/payment/'.$prefix.'/diners_club.png') }}" class="payment-logo">
                                                <img src="{{ asset('img/payment/'.$prefix.'/amex.png') }}" class="payment-logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 border-bottom">
                                    <div class="d-flex align-items-center py-2">
                                        <div class="payment-sel">
                                            <input class="form-check-input" type="radio" name="payment_method" value="digital_wallet" wire:model.live="payment_method" @if($prefix == "g") disabled @endif > 
                                        </div>
                                        <div class="payment-type-text ms-3">
                                            <p class="m-0 p-0 @if($prefix == 'g') text-muted @endif">Pay with digital wallet</p>
                                            <p class="m-0 p-0 text-muted"><i>Connivance fee: 1% of the total value of the transaction</i></p>
                                        </div>
                                        <div class="payment-logos">
                                            <div class="d-flex">
                                                <img src="{{ asset('img/payment/'.$prefix.'/apple_pay.png') }}" class="payment-logo">
                                                <img src="{{ asset('img/payment/'.$prefix.'/google_pay.png') }}" class="payment-logo">
                                                <img src="{{ asset('img/payment/'.$prefix.'/samsung_pay.png') }}" class="payment-logo">
                                                <img src="{{ asset('img/payment/'.$prefix.'/click_to_pay.png') }}" class="payment-logo">
                                            </div>
                                        </div>
                                    </div>
                                    @if($payment_method == "digital_wallet")
                                    <div class="text-end">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="digital_wallet_type" id="apple_pay" value="apple_pay" wire:model.defer="digital_wallet_type">
                                            <label class="form-check-label" for="apple_pay">Apple Pay</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="digital_wallet_type" id="google_pay" value="google_pay" wire:model.defer="digital_wallet_type">
                                            <label class="form-check-label" for="google_pay">Google Pay</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="digital_wallet_type" id="samsung_pay" value="samsung_pay" wire:model.defer="digital_wallet_type">
                                            <label class="form-check-label" for="samsung_pay">Samsung Pay</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="digital_wallet_type" id="click_to_pay" value="click_to_pay" wire:model.defer="digital_wallet_type">
                                            <label class="form-check-label" for="click_to_pay">Click To Pay</label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12 mt-4 p-3 bg-grey">
                                    <b>Why are you charged a convenience fee?</b>
                                    <p class="m-0 p-0">When you opt to use a non-standard payment channel or method, a convenience fee is levied by the merchant offering the payment service.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <h2 class="page-title pb-0 mb-0">Summary</h2>
                            <ul class="list-group mt-4">
                                <li class="list-group-item d-flex">
                                    <span><b>Sub-Total</b></span>
                                    <span class="ms-auto"><b>R {{ number_format($cart_sub_total, 2) }}</b></span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span><b>Delivery</b></span>
                                    <span class="ms-auto"><b>R {{ number_format($shipping_tot, 2) }}</b></span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span><b>Platform Fees</b></span>
                                    <span class="ms-auto"><b>R {{ number_format($service_fees, 2) }}</b></span>
                                </li>
                                @if($voucher_discount_amount)
                                <li class="list-group-item d-flex">
                                    <span><b>Voucher Discount</b></span>
                                    <span class="ms-auto"><b>-R {{ number_format($voucher_discount_amount, 2) }}</b></span>
                                </li>
                                @endif
                                @if($vendor_promo_amount)
                                <li class="list-group-item d-flex">
                                    <span><b>Promo Discount</b></span>
                                    <span class="ms-auto"><b>-R {{ number_format($vendor_promo_amount, 2) }}</b></span>
                                </li>
                                @endif
                            </ul>
                            <div class="row mt-3 ms-1 me-1 border-bottom">
                                <div class="col-md-12 d-flex">
                                    <b>TOTAL</b>
                                    <b class="ms-auto">R {{ number_format($total, 2) }}</b>
                                </div>
                            </div>
                            @if($voucher_discount_amount)
                                @if($voucher_discount_amount > $cart_total)
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="alert alert-info" role="alert">
                                            <b>NOTE: </b>Voucher balance will be deposited into your AB wallet.
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms_check" wire:model.defer="terms_and_conditions">
                                <label class="form-check-label" for="terms_check">
                                    <small style="color: #000">I acknowledge that I have read and understood the <a href="{{ url('docs/Terms_of_Use_V3_2_Revised.pdf') }}" target="_blank" style="font-weight: 600;">Terms and Conditions</a>. I confirm that I am legally authorized to use this platform and that I will comply with all applicable South African laws, including the Firearms Control Act (60), 2020. I understand that I am solely responsible for ensuring compliance with all relevant regulations and laws.</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4 text-center">
                            <a href="#" class="btn btn-secondary" wire:click.prevent="processPayment">Proceed with payment</a>
                            @if(Auth::user()->wallet_total() > $cart_total)
                            <a href="#"class="btn btn-primary-outline" wire:click.prevent="processPayment('wallet')">Pay with wallet</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @push('scripts')
    <script src="https://js.walletdoc.com/v1/walletdoc.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            
            @this.on('wallet-process', (event) => {
                var pub = event.pub
                var id = event.id;
                var key = event.key;
                console.log(event.pub);
                console.log(event.id);
                console.log(event.key);

                let walletdoc = Walletdoc(pub);
                console.log(walletdoc);
                walletdoc.processTransaction({
                    transactionId: id,
                    clientKey: key
                }).then(function(result) {
                    console.log(result);
                });
            });
            @this.on('send-to-payment', (event) => {
                var trx_id = event.id;
                var url = event.url;

                console.log(trx_id);
                console.log(url);
                
                var form = $(document.createElement('form'));
                $(form).attr("action", url);
                $(form).attr("method", "POST");

                var input = $("<input>").attr("type", "hidden").attr("name", 'id').val(trx_id);
                $(form).append($(input));

                $(document.body).append(form);
                $(form).submit();
            });

            @this.on('go-to-top', () => {
                $("html, body").animate({ scrollTop: 0 }, "slow");
            });
            @this.on('process-payment', (event) => {
                var data = JSON.parse(event.data);

                url = '{{ $payment_url }}';
                console.log(url);
                
                var form = $(document.createElement('form'));
                $(form).attr("action", url);
                $(form).attr("method", "POST");

                $.each(data, function(key,val){
                    var input = $("<input>").attr("type", "hidden").attr("name", key).val(val);
                    $(form).append($(input));
                });
                // console.log(form)
                $(document.body).append(form);
                $(form).submit();
                
            });
        });
        $(document).ready(function(){
            $('.qty').on('change', function(){
                updateQty($(this))
            });
            $('.plus').on('click', function() {
                var input = $(this).siblings('input[type="text"]');
                updateQty(input)           
            });
            $('.minus').on('click', function() {
                var input = $(this).siblings('input[type="text"]');
                updateQty(input)           
            });
        });
        function updateQty(elem){
            var id = $(elem).data('id');
            var qty = parseInt($(elem).val());
            @this.dispatch('update-quantity', { id: id, qty: qty });
        }
    </script>
    @endpush
</div>
