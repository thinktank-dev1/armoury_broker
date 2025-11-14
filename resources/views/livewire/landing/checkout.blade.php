<div>
    <div class="section py-5 bg-grey" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="row">
                        <div class="col-md-12">
                            <a class="text-dark-blue" href="{{ URL::previous() }}">
                                <i class="fas fa-chevron-left"></i> &nbsp;&nbsp;Back
                            </a>
                        </div>
                        <div class="col-md-12 mt-4">
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
                                                                <span class="ms-auto"><b>{{ ucwords($product->item_name) }}</b></span>
                                                            </li>
                                                            @if($product->model_number)
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Model</small>
                                                                <span class="ms-auto"><b>{{ $product->model_number }}</b></span>
                                                            </li>
                                                            @endif
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Vendor</small>
                                                                <span class="ms-auto"><b>{{ ucwords($item['vendor_name']) }}</b></span>
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
                                                                <small class="">Price</small>
                                                                <span class="ms-auto"><b>R {{ number_format($item['price'], 2) }}</b></span>
                                                            </li>
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
                                                                            <input class="form-check-input" type="radio" id="shipping_method_{{ $ship->id }}" value="{{ $ship->type }}" name="shipping_method" wire:model.live="cart.{{ $k }}.shipping_method">
                                                                            <label class="form-check-label" for="shipping_method_{{ $ship->id }}">
                                                                                {{ ucwords(str_replace('_', ' ',$ship->type)) }}
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
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="dealers" id="{{ $product->id }}_ab_dealers" value="ab dealer" wire:model.live="cart.{{ $k }}.dealer_option"> 
                                                                        <label class="form-check-label" for="{{ $product->id }}_ab_dealers">
                                                                            Use AB dealers
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="dealers" id="{{ $product->id }}_custom_dealers" value="custom dealer" wire:model.live="cart.{{ $k }}.dealer_option"> 
                                                                        <label class="form-check-label" for="{{ $product->id }}_custom_dealers">
                                                                            Use my dealers
                                                                        </label>
                                                                    </div>
                                                                </span>
                                                            </li>
                                                            @endif

                                                            @if($item['dealer_option'] == "ab dealer")
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Select AB dealer</small>
                                                                <span class="ms-auto">
                                                                    <div class="">
                                                                        <select class="form-control" name="courier_shipping" wire:model.live="cart.{{ $k }}.ab_dealer_id">
                                                                            <option value="">Select Option</option>
                                                                            @foreach($dealers AS $dl)
                                                                            <option value="{{ $dl->id }}">{{ $dl->business_name.' (R '.$dl->dealer_stocking_fee.' pm)' }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </span>
                                                            </li>
                                                            @endif
                                                            @if($item['dealer_option'] == "custom dealer")
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Dealer Details</small>
                                                                <span class="ms-auto">
                                                                    <div class="">
                                                                        <textarea name="dealer_details" wire:model.blur="cart.{{ $k }}.custom_dealer_details"></textarea>
                                                                    </div>
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
                                                            @if($item['deliver_collection'] == "Courier" || $item['deliver_collection'] == "seller delivery")
                                                            <li class="list-group-item d-flex">
                                                                <small class="">Delivery Address</small>
                                                                <span class="ms-auto">
                                                                    <div class="">
                                                                        <textarea class="form-control" name="delivery_address" wire:model.blur="cart.{{ $k }}.delivery_address"></textarea>
                                                                    </div>
                                                                </span>
                                                            </li>
                                                            @endif
                                                            <li class="list-group-item">
                                                                <small style="font-size: 13px;"><b style="font-weight: 500;">Platform Fee selected by Seller:</b> {{ $item['product']->service_fee_payer }}</small>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <h2 class="page-title pb-0 mb-0">Platform Fees</h2>
                            <p><small><b>Please Note: </b>Armoury Broker allows the fee to be covered by either the buyer or the seller or split between the parties on a 50-50 basis.</small></p>
                        </div>

                        <div class="@if($has_vendor_promo_codes) col-md-6 @else col-md-12 @endif mt-4 mb-4">
                            <h2 class="page-title pb-0 mb-0">Apply Voucher Code</h2>
                            <div class="mb-3">
                                <label class="form-label">Enter Voucher Code</label>
                                <input type="text" class="form-control" aria-describedby="voucher_help_text" name="voucher_code" wire:model.blur="voucher_code">
                                <div id="voucher_help_text" class="form-text text-danger">
                                    @if($voucher_error)
                                    {{ $voucher_error }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($has_vendor_promo_codes)
                        <div class="col-md-6 mt-4 mb-4">
                            <h2 class="page-title pb-0 mb-0">Apply Promo Code</h2>
                            <div class="mb-3">
                                <label class="form-label">Enter Promo Code</label>
                                <input type="text" class="form-control" aria-describedby="promo_help_text" name="vendor_promo_code" wire:model.blur="vendor_promo_code">
                                <div id="promo_help_text" class="form-text text-danger">
                                    @if($vendor_promo_code_error)
                                    {{ $vendor_promo_code_error }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-12 mt-1">
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
                                    <span class="ms-auto"><b>R {{ number_format($voucher_discount_amount, 2) }}</b></span>
                                </li>
                                @endif
                                @if($vendor_promo_amount)
                                <li class="list-group-item d-flex">
                                    <span><b>Promo Discount</b></span>
                                    <span class="ms-auto"><b>R {{ number_format($vendor_promo_amount, 2) }}</b></span>
                                </li>
                                @endif
                            </ul>
                            <div class="row mt-3">
                                <div class="col-md-12 d-flex">
                                    <b>TOTAL</b>
                                    <b class="ms-auto">R {{ number_format($total, 2) }}</b>
                                </div>
                                <div class="col-md-12">
                                    <hr />
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
                        @if(Auth::user()->vendor->balance() > 0)
                        <div class="col-md-12 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pay_with_wallet" wire:model.live="pay_with_wallet">
                                <label class="form-check-label" for="pay_with_wallet">
                                    Would you like to pay with your wallet
                                </label>
                            </div>
                            @if($show_wallet_options)
                            <div class="mt-3">
                                @if(Auth::user()->vendor->withdrawableBalance() > 0)
                                    <div class="mb-3">
                                        <label class="form-label">Withdrawable Credit (<b>R {{ number_format(Auth::user()->vendor->withdrawableBalance(),2) }}</b>)</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">R</span>
                                            <input type="text" class="form-control" name="credit_payment" wire:model.blur="credit_payment">
                                        </div>
                                        @if($credit_error)
                                        <div id="emailHelp" class="form-text text-danger">{{ $credit_error }}</div>
                                        @endif
                                    </div>
                                @endif
                                @if(Auth::user()->vendor->giftVoucherBalance() > 0)
                                    <div class="mb-3">
                                        <label class="form-label">Gift Voucher Credit (<b>R {{ number_format(Auth::user()->vendor->giftVoucherBalance(),2) }}</b>)</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">R</span>
                                            <input type="text" class="form-control" name="gift_voucher_payment" wire:model.blur="gift_voucher_payment">
                                        </div>
                                        @if($gf_error)
                                        <div id="emailHelp" class="form-text text-danger">{{ $gf_error }}</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endif
                        <div class="col-md-12 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms_check" wire:model.defer="terms_and_conditions">
                                <label class="form-check-label" for="terms_check">
                                    <small style="color: #000">I acknowledge that I have read and understood the <a href="{{ url('terms-and-conditions') }}" style="font-weight: 600;">Terms and Conditions</a>. I confirm that I am legally authorized to use this platform and that I will comply with all applicable South African laws, including the Firearms Control Act (60), 2020. I understand that I am solely responsible for ensuring compliance with all relevant regulations and laws.</small>
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
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
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
