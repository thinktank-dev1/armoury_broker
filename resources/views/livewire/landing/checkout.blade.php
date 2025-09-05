<div>
    <div class="section py-5">
        <div class="container">
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
                <div class="col-md-12 mt-3 bg-grey p-3">
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
                                        <div class="accordion-body">
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
                                                                <input type="text" name="quantity" value="{{ $item['qty'] }}" title="Qty" class="qty" data-id="{{ $item['id'] }}" size="4">
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
                                                                @if($product->allow_collection)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="deliver_collection" value="collection" id="{{ $product->id }}_collection" wire:model.live="cart.{{ $k }}.deliver_collection">
                                                                    <label class="form-check-label" for="{{ $product->id }}_collection">
                                                                        Collection
                                                                    </label>
                                                                </div>
                                                                @endif
                                                                @if($product->delivery_type == "in person" || $product->delivery_type == "Free Delivery")
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="deliver_collection" value="seller delivery" id="{{ $product->id }}_buyer_delivery" wire:model.live="cart.{{ $k }}.deliver_collection">
                                                                    <label class="form-check-label" for="{{ $product->id }}_buyer_delivery">
                                                                        Delivery
                                                                    </label>
                                                                </div>
                                                                @endif
                                                                @if($product->delivery_type == "Courier")
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="deliver_collection" value="Courier" id="{{ $product->id }}_courier" wire:model.live="cart.{{ $k }}.deliver_collection">
                                                                    <label class="form-check-label" for="{{ $product->id }}_courier">
                                                                        Courier
                                                                    </label>
                                                                </div>
                                                                @endif
                                                                @if($product->deler_stock)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="deliver_collection" value="dealer stock" id="{{ $product->id }}_dealer_tp" wire:model.live="cart.{{ $k }}.deliver_collection">
                                                                    <label class="form-check-label" for="{{ $product->id }}_dealer_tp">
                                                                        Dealer Stock
                                                                    </label>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @if($item['deliver_collection'] == "dealer stock")
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

                        {{--
                        <table class="table check-out-table">
                            <thead>
                                <tr>
                                    <th class="text-start">Order Number</th>
                                    <th class="text-start">Name</th>
                                    <th class="text-start">Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th>Shipping</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart AS $k=>$item)
                                    <tr>
                                        <td class="text-start pb-0 mb-0 pt-4">#{{ $item['oder_no'] }}</td>
                                        <td class="text-start pb-0 mb-0 pt-4">{{ ucwords($item['vendor_name']) }}</td>
                                        <td class="text-start pb-0 mb-0 pt-4">
                                            <div class="d-flex">
                                                @if($item['item_image'])
                                                    <img src="{{ asset('storage/'.$item['item_image']) }}" class="table-image">
                                                @else
                                                    <img src="{{ asset('img/no-image.webp') }}" class="table-image">
                                                @endif
                                                <span class="ms-3">{{ $item['item_name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="product-quantity pb-0 mb-0 pt-4" data-title="Quantity">
                                            <div class="quantity">
                                                <input type="button" value="-" class="minus">
                                                <input type="text" name="quantity" value="{{ $item['qty'] }}" title="Qty" class="qty" data-id="{{ $item['id'] }}" size="4">
                                                <input type="button" value="+" class="plus">
                                            </div>
                                        </td>
                                        <td class="pb-0 mb-0 pt-4">R {{ number_format($item['price'], 2) }}</td>
                                        <td class="pb-0 mb-0 pt-4">R {{ number_format($item['total'], 2) }}</td>
                                        <td class="pb-0 mb-0 pt-4">
                                            @if($item['product']->shippingOptions->count() > 0)
                                            <select class="form-control"name="shipping" wire:model.live="cart.{{ $k }}.shipping_id" style="max-width: 150px; height: 30px; padding: 2px 8px;">
                                                <option value="">Select Option</option>
                                                @foreach($item['product']->shippingOptions AS $sh)
                                                <option value="{{ $sh->id }}">{{ $sh->type.'(R'.$sh->price.')' }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                            @if($item['product']->allow_collection == 1)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="{{ $item['id'] }}_collection_free_shipping" id="{{ $item['id'] }}_collction_radio" value="Collection" wire:model.defer="cart.{{ $k }}.collection_free_shipping">
                                                    <label class="form-check-label" for="{{ $item['id'] }}_collction_radio">Collection</label>
                                                </div>
                                            @endif
                                            @if($item['product']->delivery_type == "Free Delivery")
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="{{ $item['id'] }}_collection_free_shipping" id="{{ $item['id'] }}_free_deliver_radio" value="Free Delivery" wire:model.defer="cart.{{ $k }}.collection_free_shipping">
                                                    <label class="form-check-label" for="{{ $item['id'] }}_free_deliver_radio">Free Delivery</label>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-start pt-0 mt-0">
                                            <small style="font-size: 13px;"><b style="font-weight: 500;">Platform Fee selected by Seller:</b> {{ $item['product']->service_fee_payer }}</small>
                                            <br />
                                            <hr />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        --}}
                    </div>
                </div>
                <div class="col-md-12 mt-3 bg-grey p-3 d-md-none">
                    <b>Cart Items</b>
                    @foreach($cart AS $k=>$item)
                    <ul class="list-group mb-3">
                        <li class="list-group-item">{{ $item['item_name'] }}</li>
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Quantity</span>
                            <div class="ms-auto">
                                <div class="quantity">
                                    <input type="button" value="-" class="minus">
                                    <input type="text" name="quantity" value="{{ $item['qty'] }}" title="Qty" class="qty" data-id="{{ $item['id'] }}" size="4">
                                    <input type="button" value="+" class="plus">
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Price</span>
                            <div class="ms-auto">
                                R {{ number_format($item['price'], 2) }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Total Price</span>
                            <div class="ms-auto">
                                R {{ number_format($item['total'], 2) }}
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="text-muted mb-2">Shipping</div>
                            @if($item['product']->shippingOptions->count() > 0)
                            <div class="mb-2">
                                <select class="form-control"name="shipping" wire:model.live="cart.{{ $k }}.shipping_id">
                                    <option value="">Select Option</option>
                                    @foreach($item['product']->shippingOptions AS $sh)
                                    <option value="{{ $sh->id }}">{{ $sh->type.'(R'.$sh->price.')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="mb-2">
                                @if($item['product']->allow_collection == 1)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="{{ $item['id'] }}_collection_free_shipping" id="{{ $item['id'] }}_collction_radio" value="Collection" wire:model.defer="cart.{{ $k }}.collection_free_shipping">
                                        <label class="form-check-label" for="{{ $item['id'] }}_collction_radio">Collection</label>
                                    </div>
                                @endif
                                @if($item['product']->delivery_type == "Free Delivery")
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="{{ $item['id'] }}_collection_free_shipping" id="{{ $item['id'] }}_free_deliver_radio" value="Free Delivery" wire:model.defer="cart.{{ $k }}.collection_free_shipping">
                                        <label class="form-check-label" for="{{ $item['id'] }}_free_deliver_radio">Free Delivery</label>
                                    </div>
                                @endif
                            </div>
                        </li>
                    </ul>
                    @endforeach
                </div>

                <div class="col-md-12 mt-4">
                    <h2 class="page-title pb-0 mb-0">Platform Fees</h2>
                    <p><small><b>Please Note: </b>Armoury Broker allows the fee to be covered by either the buyer or the seller or split between the parties on a 50-50 basis.</small></p>
                </div>

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
                    </ul>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex">
                            <b>TOTAL</b>
                            <b class="ms-auto">R {{ number_format($cart_total, 2) }}</b>
                        </div>
                        <div class="col-md-12">
                            <hr />
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms_check" wire:model.defer="terms_and_conditions">
                        <label class="form-check-label" for="terms_check">
                            <small>I acknowledge that I have read and understood the <a href="{{ url('terms-and-conditions') }}">Terms and Conditions</a>. I confirm that I am legally authorized to use this platform and that I will comply with all applicable South African laws, including the Firearms Control Act (60), 2020. I understand that I am solely responsible for ensuring compliance with all relevant regulations and laws.</small>
                        </label>
                    </div>
                </div>
                <div class="col-md-12 mt-4 text-center">
                    <a href="#" class="btn btn-primary" wire:click.prevent="processPayment">Proceed with payment</a>
                    @if(Auth::user()->wallet_total() > $cart_total)
                    <a href="#"class="btn btn-primary-outline" wire:click.prevent="processPayment('wallet')">Pay with wallet</a>
                    @endif
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
