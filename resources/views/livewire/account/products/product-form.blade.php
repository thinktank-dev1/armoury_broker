<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <form wire:submit.prevent="saveProduct">
                @if($cur_id)
                <h3 class="page-title bold">
                    @if(url()->current() != URL::previous())
                    <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                    @endif
                    EDIT ITEM
                </h3>
                @else
                <h3 class="page-title bold">
                    @if(url()->current() != URL::previous())
                    <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                    @endif
                    LIST A NEW ITEM
                </h3>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex">
                                <a href="#" class="btn @if($listing_type == 'sale') btn-dark-blue @else btn-dark-blue-outline @endif list-type" wire:click.prevent="setListingType('sale')">For Sale</a>
                                <a href="#" class="btn @if($listing_type == 'wanted') btn-dark-blue @else btn-dark-blue-outline @endif list-type" wire:click.prevent="setListingType('wanted')">Wanted</a>
                                <div class="mt-2">
                                    <span class="mytooltip tooltip-effect-1">
                                        <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                        <span class="tooltip-content clearfix" style="bottom: -260px;">
                                            <span class="tooltip-text px-2">
                                                <b class="bold">Item Listing Types</b><br />
                                                <ul>
                                                    <li><b>For Sale:</b> Seller listing an item for sale to a buyer.</li>
                                                    <li><b>Wanted:</b> Buyers list what they need, and sellers who have the item can contact the buyer through the platform.</li>
                                                </ul>
                                            </span> 
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div> 
                        @if($errors->any())
                        <div class="row my-3">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (session('status'))
                        <div class="row my-3">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row mt-5">
                            <div cass="col-md-12">
                                <h3 class="bold">UPLOAD ITEM</h3>
                                <b class="bold">Image Upload</b>
                                <p>Upload up to 6 images <span class="ms-5"><a href="{{ url('docs/Armoury Broker Guideline Website.pdf') }}" target="_blank" class="text-black"><b><u>View image upload guide</u></b></a></span></p>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    @if($cur_product)
                                        @php
                                        $cnt = 0;
                                        @endphp
                                        @foreach($cur_product->images AS $image)
                                            @php
                                            $cnt += 1;
                                            @endphp
                                            <div class="col-md-2">
                                                <div class="img-cont @if($preview) img-cont-preview @endif d-flex justify-content-center align-items-center">
                                                    <div class="preview-cont w-100 h-100">
                                                        <img src="{{ asset('storage/'.$image->image_url) }}" class="prdt-img">
                                                        <a href="#" wire:click.prevent="deleteImage('{{ $image->id }}')"><span class="img-rem-icon"><i class="fas fa-times"></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($cnt < 5)
                                            @foreach($product_images AS $key => $value)
                                            @php
                                            $cnt += 1;
                                            @endphp
                                            <div class="col-md-2">
                                                <div class="img-cont @if($preview) img-cont-preview @endif d-flex justify-content-center align-items-center" onclick="triggerFileInput(this)">
                                                    @if($value)
                                                        @if($value->temporaryUrl())
                                                            @if(str_starts_with($value->getMimeType(), 'image/'))
                                                            <div class="preview-cont w-100 h-100">
                                                                <img src="{{ $value->temporaryUrl() }}" class="prdt-img">
                                                                <a href="#" wire:click.prevent="removeImage('{{ $key }}')"><span class="img-rem-icon"><i class="fas fa-times"></i></span></a>
                                                            </div>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <i class="ti-plus"></i>
                                                        <input type="file" accept="image/*" wire:model.live="product_images.{{ $key }}">
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                            if($cnt == 6){
                                                break;
                                            }
                                            @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @foreach($product_images AS $key => $value)
                                        <div class="col-md-2">
                                            <div class="img-cont @if($preview) img-cont-preview @endif d-flex justify-content-center align-items-center" onclick="triggerFileInput(this)">
                                                @if($value)
                                                    @if($value->temporaryUrl())
                                                        @if(str_starts_with($value->getMimeType(), 'image/'))
                                                        <div class="preview-cont w-100 h-100">
                                                            <img src="{{ $value->temporaryUrl() }}" class="prdt-img">
                                                            <a href="#" wire:click.prevent="removeImage('{{ $key }}')"><span class="img-rem-icon"><i class="fas fa-times"></i></span></a>
                                                        </div>
                                                        @endif
                                                    @else
                                                    <img src="{{ asset('storage/'.$value) }}" class="img-responsive prdt-img">
                                                    @endif
                                                @else
                                                    <i class="ti-plus"></i>
                                                    <input type="file" accept="image/*" wire:model.live="product_images.{{ $key }}">
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 d-flex">
                                        <h3 class="bold">ITEM DETAILS</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <input type="text" class="form-control" placeholder="Listing Title*" name="item_name" wire:model.blur="item_name"> 
                                        </div>
                                        <div class="form-group mb-2">
                                            <input type="text" class="form-control" placeholder="Model Number" name="model_number" wire:model.blur="model_number"> 
                                        </div>
                                        <div class="form-group mb-2">
                                            <input type="text" class="form-control" placeholder="Description*" name="item_description" wire:model.blur="item_description">
                                        </div>
                                        <div class="form-group mb-2">
                                            <select class="form-control" placeholder="Category" name="category_id*" wire:model.live="category_id">
                                                <option value="">Category*</option>
                                                @foreach($cats AS $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <select class="form-control" placeholder="Sub category" name="sub_category_id*" wire:model.live="sub_category_id">
                                                <option value="">Sub Category*</option>
                                                @if($category)
                                                    @foreach($category->sub_cats->whereNull('parent_id') AS $sub)
                                                        <option value="{{ $sub->id }}">{{ $sub->sub_category_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @if(count($sub_sub) > 0)
                                        <div class="form-group mb-2">
                                            <select class="form-control" placeholder="Sub Sub category" name="sub_sub_category_id*" wire:model.blur="sub_sub_category_id">
                                                <option value="">Sub-Sub-Category*</option>
                                                @if($sub_sub)
                                                    @foreach($sub_sub AS $sub)
                                                        <option value="{{ $sub['id'] }}">{{ $sub['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @endif
                                        @if($category)
                                            @if($category->measurement_type)
                                            <div class="form-group mb-2">
                                                @if($category->measurement_type == "caliber")
                                                    <select class="form-control" name="size" wire:model.defer="size">
                                                        <option value="">Select Calibre</option>
                                                        @foreach($calibers AS $cal)
                                                        <option value="{{ $cal->caliber }}">{{ $cal->caliber }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($category->measurement_type == "size")
                                                    <select class="form-control" placeholder="Size" name="size" wire:model.defer="size">
                                                        <option value="">Size</option>
                                                        @foreach($sizes AS $sz)
                                                        <option value="{{ $sz }}">{{ $sz }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="text" class="form-control" placeholder="{{ ucwords($category->measurement_type) }}" name="size" wire:model.defer="size">
                                                @endif
                                            </div>
                                            @endif
                                        @endif
                                        <div class="form-group mb-2">
                                            <select class="form-control" placeholder="Brand*" name="brand_id" wire:model.blur="brand_id">
                                                <option value="">Brand*</option>
                                                @foreach($brands AS $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <select class="form-control" placeholder="Condition*" name="condition" wire:model.blur="condition">
                                                <option value="">Condition*</option>
                                                @foreach($conditions AS $cond)
                                                <option value="{{ $cond }}">{{ $cond }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <input type="number" class="form-control" placeholder="Quantity*" name="quantity" wire:model.live="quantity"> 
                                        </div>
                                    </div>    
                                </div>
                                @if($listing_type == 'sale')
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h3 class="bold">PLATFORM FEES</h3>
                                        <p><small><b>Note:</b> Armoury Broker allows the fee to be covered by either the buyer or the seller or split between the parties on 50 - 50 basis.</small></p>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="paid_by_buyer" name="service_fee" value="buyer" wire:model.defer="service_fee_payer">
                                            <label class="form-check-label" for="paid_by_buyer">
                                                Paid by buyer ({{ $fee }}% added to the purchase price)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="paid_by_seller" name="service_fee" value="seller" wire:model.defer="service_fee_payer">
                                            <label class="form-check-label" for="paid_by_seller">
                                                Paid by seller ({{ $fee }}% deducted from sales price prior to payout)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="b-5-5" name="service_fee" value="50-50" wire:model.defer="service_fee_payer">
                                            <label class="form-check-label" for="b-5-5">
                                                50 - 50 (Each party pays half of the platform fee - {{ $fee/2 }}% each)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h3 class="bold">SHIPPING</h3>
                                        <p><small><b>Note:</b> To be managed outside of the platform by the Seller.</small></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="" id="collection_delivery" wire:model.live="collection_delivery">
                                            <label class="form-check-label" for="collection_delivery">
                                                Collections / Delivery 
                                                <span class="mytooltip tooltip-effect-1">
                                                    <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                                    <span class="tooltip-content clearfix">
                                                        <span class="tooltip-text px-2">
                                                            <b>Delivery / Collection</b><br /> 
                                                            Buyer and seller coordinate pickup or delivery details through the platform's messaging system
                                                        </span> 
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                        @if($category)
                                            @if(!$category->regulated)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="" id="courier" wire:model.live="courier">
                                                <label class="form-check-label" for="courier">
                                                    Courier (Flat Fee of R 99.00)
                                                    <span class="mytooltip tooltip-effect-1">
                                                    <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                                    <span class="tooltip-content clearfix">
                                                        <span class="tooltip-text px-2">
                                                            <b>Courier</b><br />
                                                            R99 flat delivery fee (refunded to seller) - arrangements made via platform messaging between buyer and seller
                                                        </span> 
                                                    </span>
                                                </span>
                                                </label>
                                            </div>
                                            @endif
                                        @endif
                                        @if($category)
                                            @if($category->regulated)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="" id="dealer_stock" wire:model.live="dealer_stock">
                                                <label class="form-check-label" for="dealer_stock">
                                                    Dealer Stocking (Firearms only)
                                                    <span class="mytooltip tooltip-effect-1">
                                                    <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                                    <span class="tooltip-content clearfix">
                                                        <span class="tooltip-text px-2">
                                                            <b>Dealer Stocking (Firearms Only)</b><br /> 
                                                            Firearm transfers through licensed dealers - coordination handled via platform messaging between buyer and seller
                                                        </span> 
                                                    </span>
                                                </label>
                                            </div>
                                            @endif
                                        @endif
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="" id="free_delivery" wire:model.live="free_delivery">
                                            <label class="form-check-label" for="free_delivery">
                                                Free Delivery
                                                <span class="mytooltip tooltip-effect-1">
                                                    <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                                    <span class="tooltip-content clearfix">
                                                        <span class="tooltip-text px-2">
                                                            <b>Free Delivery</b><br /> 
                                                            No delivery charge - buyer and seller arrange delivery details through the platform messaging system
                                                        </span> 
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                        @if($dealer_stock)
                                            <div class="mb-3">
                                                <label class="form-label">Please select a dealer type</label>
                                                <select class="form-control" name="dealer_stock_type" wire:model.live="dealer_stock_type">
                                                    <option value="">Select Option</option>
                                                    <option value="ab_dealer">Armoury Broker Dealer</option>
                                                    <option value="custom_dealer">Private Dealer</option>
                                                </select>
                                            </div>
                                            @if($dealer_stock_type == 'ab_dealer')
                                                @if($dealers->count() > 0)
                                                <div class="mb-3">
                                                    <label class="form-label">Select Armoury Broker Dealer</label>
                                                    <select class="form-control" name="ab_dealer_id" wire:model.defer="ab_dealer_id">
                                                        <option value="">Select Option</option>
                                                        @foreach($dealers AS $dl)
                                                        <option value="{{ $dl->id }}">{{ $dl->business_name.' (R'.number_format($dl->dealer_stocking_fee,2).')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @else
                                                <div class="alert alert-warning" role="alert">
                                                    There are currently no Armoury Broker dealers within your area, please select private dealer.
                                                </div>
                                                @endif
                                            @elseif($dealer_stock_type == 'custom_dealer')
                                            <div class="mb-3">
                                                <textarea class="form-control" name="private_dealer_details" placeholder="Enter private dealer's detail and physical address*" wire:model.defer="private_dealer_details"></textarea>
                                            </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h3 class="bold">ITEM PRICE</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <input type="text" class="form-control" placeholder="Item Price*" name="item_price" wire:model.blur="item_price"> 
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="allow_offers" name="allow_offers" wire:model.defer="allow_offers">
                                            <label class="form-check-label" for="allow_offers">
                                                Open to offers
                                                <span class="mytooltip tooltip-effect-1">
                                                    <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                                    <span class="tooltip-content clearfix">
                                                        <span class="tooltip-text px-2">
                                                            <b>Open to offers</b><br /> 
                                                            Limited to 20% lower than the listed price
                                                        </span> 
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="acknowledgement" name="acknowledgement" wire:model.defer="acknowledgement">
                                            <label class="form-check-label" for="acknowledgement">
                                                <p>I have read and agree to the platform <a href="docs/Terms%20of%20Use%20and%20User%20Agreement_AB_Courier%20amendments_v02_20250629.pdf" target="_blank" class="bold">Terms and Conditions</a></p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12 d-grid">
                                        <input type="submit" class="btn btn-primary" value="List Item">    
                                    </div>
                                </div>

                                @if($cur_id)
                                <div class="row mt-3 mb-5">
                                    <div class="col-md-12 d-grid">
                                        <a href="#" class="btn btn-outline-danger" wire:click.prevent="removeItem">Remove Item</a>    
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if($preview)
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="bold text-upper">Preview Listing</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="product-gallery">
                                                    @php
                                                    $img = null;
                                                    $active = null;
                                                    foreach($product_images AS $key => $value){
                                                        if($value){
                                                            if($value->temporaryUrl()){
                                                                if(str_starts_with($value->getMimeType(), 'image/')){
                                                                    $img = $value->temporaryUrl();
                                                                }
                                                            }
                                                            else{
                                                                $img = 'storage/'.$value;
                                                            }
                                                        }
                                                        if($img){
                                                            //$active = $loop->index;
                                                            break;
                                                        }
                                                    }
                                                    if(!$img){
                                                        $img = 'img/cat-placeholder-image.jpg';
                                                        $active = 0;
                                                    }
                                                    @endphp
                                                    <div class="main-image">
                                                        <img id="currentImage" src="{{ asset($img) }}" alt="Glock 19">
                                                    </div>
                                                    <div class="thumbnails">
                                                        @foreach($product_images AS $key => $value)
                                                            @if($value)
                                                                @if($value->temporaryUrl())
                                                                    @if(str_starts_with($value->getMimeType(), 'image/'))
                                                                        <img src="{{ $value->temporaryUrl() }}" alt="" class="thumb @if($loop->index == $active) active @endif">
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <img src="{{ asset('img/cat-placeholder-image.jpg') }}" alt="" class="thumb @if($loop->index == $active) active @endif">
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 pt-4">
                                                <p>{{ $item_name ?? 'Item name' }}</p>
                                                <h4 class="bold">R {{ number_format($item_price,2) ?? '0.00' }}</h4>
                                                <div class="cart-product-quantity">
                                                    <div class="quantity">
                                                        <input type="button" value="-" class="minus" wire:click.prevent="updatePreviewQty('minus')">
                                                        <input type="text" name="quantity" title="Qty" class="qty" size="4" wire:model.defer="preview_quantity">
                                                        <input type="button" value="+" class="plus" wire:click.prevent="updatePreviewQty('plus')">
                                                    </div>
                                                </div>
                                                <p>Available quantity: <b>{{ $quantity ?? 0 }}</b></p>
                                                <p>{{ $item_description }}</p>
                                                <div class="row mt-3">
                                                    <div class="col-md-12 d-flex gap-5">
                                                        <div class="">
                                                            <i class="fas fa-star"></i> 0
                                                        </div>
                                                        <div class="">
                                                            <i class="icon-location-pin"></i> {{ Auth::user()->vendor->city }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12 d-flex">
                                                        @if($category)
                                                        <span class="badge badge-outine-dark-blue me-1">{{ $category->category_name }}</span>
                                                        @endif
                                                        @if($sub_name)
                                                        <span class="badge badge-outine-dark-blue me-1">{{ $sub_name }}</span>
                                                        @endif
                                                        @if($sub_sub_name)
                                                        <span class="badge badge-outine-dark-blue me-1">{{ $sub_sub_name }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12 d-flex">
                                                        @if($brand_name)
                                                        <span class="badge badge-outine-dark-blue me-1">{{ $brand_name }}</span>
                                                        @endif
                                                        @if($condition)
                                                        <span class="badge badge-outine-dark-blue me-1">{{ $condition }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                        </div>
                    </div>
                </div>            
            </form>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.thumb').on('click', function() {
                const newSrc = $(this).attr('src');
                $('#currentImage').attr('src', newSrc);
                $('.thumb').removeClass('active');
                $(this).addClass('active');
            });
        });
        function triggerFileInput(elem){
            const input = elem.querySelector('input[type="file"]');
            input.click();
        }
        document.addEventListener('livewire:initialized', () => {
            @this.on('go-to-top', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            @this.on('item-saved', (e) => {
                id = e.id;
                Swal.fire({
                    type: 'success',
                    title: "Congrats, item added!",
                    html: `<div class="row">
                        <div class="col-md-12">
                            <p>Your item is now live.</p>
                        </div>
                        <div class="col-md-12 d-grid mb-3">
                            <a href="{{ url('shop/product/') }}/${id}" class="btn btn-primary">Go to item</a>
                        </div>
                        <div class="col-md-12 d-grid mb-3">
                            <a href="{{ url('my-armoury') }}" class="btn btn-primary">Go to your armoury</a>
                        </div>
                        <div class="col-md-12 d-grid mb-3">
                            <a href="{{ url('list-item') }}" class="btn btn-primary">Add new item</a>
                        </div>
                    </div>`,
                    showConfirmButton: false,  // hides the OK button
                    showCancelButton: false,   // hides the Cancel button
                    allowOutsideClick: false,  // prevents closing when clicking outside
                });
            });
        });
    </script>
    @endpush
</div>