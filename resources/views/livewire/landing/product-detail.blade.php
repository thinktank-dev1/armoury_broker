<div>
    <div class="section py-5">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-md-12 d-flex">
                    <a class="text-dark-blue" href="{{ URL::previous() }}">
                        <i class="fas fa-chevron-left"></i> &nbsp;&nbsp;Back
                    </a>
                    <div class="ms-auto d-flex gap-3">
                        <livewire:landing.partials.report-block :vendor_id="$product->vendor->id" />
                        @if(!Auth::guest())
                        <a href="#" wire:click.prevent="addToWishList({{ $product->id }})">
                            @if(Auth::user()->whilist_item($product->id))
                            <i class="fas fa-star"></i>
                            @else
                            <i class="far fa-star"></i>
                            @endif
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    @if($product->images->count() > 0)
                    <div class="product-image">
                        <div class="product_img_box">
                            <img id="product_img" src="{{ asset('storage/'.$product->images->first()->image_url) }}" alt="product_img1">
                            <a href="#" class="product_img_zoom" title="Zoom">
                                <span class="linearicons-zoom-in"></span>
                            </a>
                        </div>
                        <div id="pr_item_gallery" class="product_gallery_item slick_slider slick-initialized slick-slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                            <div class="slick-list draggable">
                                <div class="slick-track" style="opacity: 1; width: 556px; transform: translate3d(0px, 0px, 0px);">
                                    @foreach($product->images AS $image)
                                    <div class="item slick-slide slick-active" data-slick-index="{{ $loop->index }}" aria-hidden="false" style="width: 129px;" tabindex="0">
                                        <a href="#" class="product_gallery_item" data-image="{{ asset('storage/'.$image->image_url) }}" data-zoom-image="{{ asset('storage/'.$image->image_url) }}" tabindex="0">
                                            <img src="{{ asset('storage/'.$image->image_url) }}" alt="product_small_img_{{ $loop->index }}">
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="pr_detail">
                        <div class="product_description">
                            <h4 class="product_title text-dark-blue">{{ ucwords($product->item_name) }}</h4>
                            <div class="product_price">
                                <span class="price">R {{ number_format($product->item_price, 2) }}</span>
                            </div>
                            <div class="cart-product-quantity">
                                <div class="quantity">
                                    <input type="button" value="-" class="minus">
                                    <input type="text" name="quantity" title="Qty" class="qty" size="4" wire:model.defer="quantity">
                                    <input type="button" value="+" class="plus">
                                </div>
                            </div>
                            <div class="pr_desc">
                                <p class="text-dark-blue">Available Quantity: {{ $product->quantity }}</p>
                                <p class="text-dark-blue">{{ $product->item_description }}</p>
                            </div>
                            <div class="d-flex gap-5 mt-3">
                                <div class="text-dark-blue">
                                    <i class="fas fa-star"></i> {{ $product->wishlists->count() }}
                                </div>
                                <div class="text-dark-blue">
                                    <i class="fas fa-map-marker-alt"></i> {{ $product->vendor->city }}
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="@if($product->allow_offers) col-md-6 @else col-md-12 @endif d-grid mb-2">
                                    <a href="#" class="bnt btn-primary" wire:click.prevent="addToCart">Buy</a>
                                </div>
                                @if($product->allow_offers)
                                <div class="col-md-6 d-grid mb-2">
                                    <a href="#" class="btn btn-primary-outline" wire:click.prevent="showOfferModal">Make An Offer</a>
                                </div>
                                @endif
                            </div>
                            <div class="mt-3">
                                <span class="badge badge-outine-dark-blue">{{ $product->category->category_name }}</span>
                                <span class="badge badge-outine-dark-blue">{{ $product->subCategory->sub_category_name }}</span>
                                @if($product->sub_sub)
                                <span class="badge badge-outine-dark-blue">{{ $product->sub_sub->sub_category_name }}</span>
                                @endif
                            </div>
                            <div class="mt-1">
                                <span class="badge badge-outine-dark-blue">{{ $product->condition }}</span>
                                <span class="badge badge-outine-dark-blue">Brand: {{ $product->brand->brand_name }}</span>
                            </div>
                            <div class="mt-4 bg-grey text-dark-blue px-3 py-2">
                                <small><b>Platform</b> and <b>Delivery</b> fees are applied to all purchase. <a href="{{ url('terms-and-conditions') }}"><b>Learn More</b></a></small>
                            </div>
                            <div class="row mt-4 px-3">
                                @if($product->vendor->avatar)
                                <div class="col-4 col-md-2">
                                    <img class="img-circle-sm img-fluid" src="{{ asset('storage/'.$product->vendor->avatar) }}">
                                </div>
                                @endif
                                <div class="@if($product->vendor->avatar) col-8 col-md-10 @else col-12 col-md-12 @endif mt-2">
                                    <div class="">
                                        <b class="text-dark-blue">{{ $product->vendor->name }}</b>
                                    </div>
                                    <div class="d-flex gap-5">
                                        <div class="text-dark-blue">
                                            <b>{{ $product->vendor->likes->count() }}</b> Likes
                                        </div>
                                        <div class="text-dark-blue">
                                            <b>0</b> Items Sold
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <livewire:landing.partials.share-block :vendor_id="$product->vendor->id" type="product-detail" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 mt-4 mb-2">
                    <h2 class="page-title">You may also like:</h2>
                </div>
                <div class="row product_list">
                    @foreach($may_likes AS $lk)
                        <livewire:landing.shop.partials.product-list-item wire:key="{{ $lk->id.now() }}" :id="$lk->id" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="offer-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Make an offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form wire:submit.prevent="saveOffer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Your Offer</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="offer-addon">R</span>
                                        <input type="number" class="form-control" placeholder="Yoour offer" aria-label="Your offer" aria-describedby="offer-addon" wire:model.defer="offer_amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveOffer">Save offer</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('added-to-cart', () => {
                $.notify("Product added to cart successfully!", "success");
            });
            @this.on('show-offer-modal', () => {
                $('#offer-modal').modal('show');
            });
            @this.on('offer-saved', () => {
                $('.modal').modal('hide');
                $.notify("Offer has been sent to vendor!", "success");
            });
        });
    </script>
    @endpush
</div>
