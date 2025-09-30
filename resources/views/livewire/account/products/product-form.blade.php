<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-material" wire:submit.prevent="saveProduct">
                        <h3 class="bold">ITEM LISTING OPTIONS</h3>
                        <div class="row mb-3">
                            <p>Select Listing Type</p>
                            <div class="col-md-12">
                                <a href="#" class="btn @if($listing_type == 'sale') btn-dark-blue @else btn-dark-blue-outline @endif" wire:click.prevent="setListingType('sale')">For Sale</a>
                                <a href="#" class="btn @if($listing_type == 'wanted') btn-dark-blue @else btn-dark-blue-outline @endif" wire:click.prevent="setListingType('wanted')">Wanted</a>
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
                                <p>Upload up to 6 images <span class="ms-5"><a href="{{ url('docs/Armoury Broker Guideline Doc.pdf') }}" target="_blank" class="text-black"><b><u>View image upload guide</u></b></a></span></p>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    @foreach($product_images AS $key => $value)
                                    <div class="col-md-2">
                                        <div class="img-cont d-flex justify-content-center align-items-center" onclick="triggerFileInput(this)">
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
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <h3 class="bold">ITEM DETAILS</h3>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label class="form-label">Item Name</label>
                                    <input type="text" class="form-control" placeholder="Item Name" name="item_name" wire:model.defer="item_name"> 
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label class="form-label">Model Number</label>
                                    <input type="text" class="form-control" placeholder="Model Number" name="model_number" wire:model.defer="model_number"> 
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label">Item Description</label>
                                    <textarea class="form-control" placeholder="Item Description" name="item_description" wire:model.defer="item_description"></textarea>
                                </div>
                            </div>
                            <div class="@if(count($sub_sub) > 0) col-md-4 @else col-md-6 @endif mt-3">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select class="form-control" placeholder="Category" name="category_id" wire:model.live="category_id">
                                        <option value="">Select Option</option>
                                        @foreach($cats AS $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="@if(count($sub_sub) > 0) col-md-4 @else col-md-6 @endif mt-3">
                                <div class="form-group">
                                    <label class="form-label">Sub Category</label>
                                    <select class="form-control" placeholder="Sub category" name="sub_category_id" wire:model.live="sub_category_id">
                                        <option value="">Select Option</option>
                                        @if($category)
                                            @foreach($category->sub_cats->whereNull('parent_id') AS $sub)
                                                <option value="{{ $sub->id }}">{{ $sub->sub_category_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @if(count($sub_sub) > 0)
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label class="form-label">Sub Sub Category</label>
                                    <select class="form-control" placeholder="Sub Sub category" name="sub_sub_category_id" wire:model.defer="sub_sub_category_id">
                                        <option value="">Select Option</option>
                                        @if($sub_sub)
                                            @foreach($sub_sub AS $sub)
                                                <option value="{{ $sub['id'] }}">{{ $sub['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>    
                            @endif
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label class="form-label">Brand</label>
                                    <select class="form-control" placeholder="Brand" name="brand_id" wire:model.defer="brand_id">
                                        <option value="">Select Option</option>
                                        @foreach($brands AS $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label class="form-label">Condition</label>
                                    <select class="form-control" placeholder="Condition" name="condition" wire:model.defer="condition">
                                        <option value="">Select Option</option>
                                        @foreach($conditions AS $cond)
                                        <option value="{{ $cond }}">{{ $cond }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control" placeholder="Quantity" name="quantity" wire:model.live="quantity"> 
                                </div>
                            </div>
                            @if($category)
                                @if($category->measurement_type)
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        @if($category->measurement_type == "caliber")
                                            <label class="form-label">Caliber</label>
                                            <input type="text" class="form-control" name="size" wire:model.defer="size">
                                        @elseif($category->measurement_type == "size")
                                            <label class="form-label">Size</label>
                                            <select class="form-control" name="size" wire:model.defer="size">
                                                <option value="">Select Option</option>
                                                @foreach($sizes AS $sz)
                                                <option value="{{ $sz }}">{{ $sz }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label class="form-label">{{ ucwords($category->measurement_type) }}</label>
                                            <input type="text" class="form-control" name="size" wire:model.defer="size">
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3 class="bold">SHIPPING</h3>
                                <p><small><b>Please Note:</b> To be managed outside of the platform by the Seller.</small></p>
                            </div>
                            <div class="row mt-4 mb-3">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="collection_check" wire:model.live="allow_collection">
                                        <label class="form-check-label" for="collection_check">
                                            Allow Collections
                                        </label>
                                    </div>
                                    @if($allow_collection)
                                    <div class="col-md-12 mt-3">
                                        <div class="mb-3">
                                            <label class="form-label">Collection Address</label>
                                            <textarea class="form-control" name="collection_address" wire:model.defer="collection_address"></textarea>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @if($category)
                                @if($category->regulated)
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="deler_stock" wire:model.live="deler_stock">
                                        <label class="form-check-label" for="deler_stock">
                                            Dealer Stock
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="in_person_delivery" id="person_delivery" wire:model.live="in_person_delivery">
                                        <label class="form-check-label" for="person_delivery">
                                            In-Person Delivery
                                        </label>
                                        <div class="form-text"><b>Note:</b> This is when the seller delivers the product to the buyer in person.</div>
                                    </div>
                                </div>
                                @endif
                            @endif
                            @if($category)
                                @if(!$category->regulated)
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="courier_free_delivery" id="courier_free_delivery_courier" value="Courier" wire:model.live="delivery_type">
                                                <label class="form-check-label" for="courier_free_delivery_courier">Courier</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="courier_free_delivery" id="courier_free_delivery_Free" value="Free Delivery" wire:model.live="delivery_type">
                                                <label class="form-check-label" for="courier_free_delivery_Free">Free Delivery</label>
                                            </div>
                                        </div>
                                    </div>
                                    @if($delivery_type == "Courier")
                                        @foreach($shipping_types AS $k => $shipping)
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Shipping Type / Courier Name</label>
                                                        <input type="text" class="form-control" placeholder="Shipping Type / Courier Name" name="shipping_name" wire:model.defer="shipping_types.{{ $k }}.type">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Price</label>
                                                        <input type="number" class="form-control" placeholder="Shipping Price" name="shipping_price" wire:model.defer="shipping_types.{{ $k }}.cost">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end pb-3">
                                                    <a href="#" class="text-danger" style="font-size: 30px;" wire:click.prevent="removeShipping({{ $k }})"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="col-md-12 mb-3">
                                            <a href="#" class="btn btn-secondary" wire:click.prevent="addShippingType">ADD MORE</a>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3 class="bold">PLATFROM FEES</h3>
                                <p><small><b>Please Note:</b> Armoury Broker allows the fee to be covered by either the buyer or the seller or split between the parties on 50 - 50 basis.</small></p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="paid_by_buyer" name="service_fee" value="buyer" wire:model.defer="service_fee_payer">
                                    <label class="form-check-label" for="paid_by_buyer">
                                        Paid by buyer ({{ $fee }}% added to the purchase price)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="paid_by_seller" name="service_fee" value="seller" wire:model.defer="service_fee_payer">
                                    <label class="form-check-label" for="paid_by_seller">
                                        Paid by seller ({{ $fee }}% deducted from sales price prior to payout)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="b-5-5" name="service_fee" value="50-50" wire:model.defer="service_fee_payer">
                                    <label class="form-check-label" for="b-5-5">
                                        50- 50 (Each party pays half of the platform fee - {{ $fee/2 }}% each)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3 class="bold">ITEM PRICE</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Item Price</label>
                                    <input type="number" class="form-control" placeholder="Item Price" name="item_price" wire:model.defer="item_price"> 
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="allow_offers" name="allow_offers" wire:model.defer="allow_offers">
                                    <label class="form-check-label" for="allow_offers">
                                        Open to offers (limited to {{ $max_offer }}% lower than the listed price)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="acknowledgement" name="acknowledgement" wire:model.defer="acknowledgement">
                                    <label class="form-check-label" for="acknowledgement">
                                        <p>I acknowledge that I have read and understood the Terms and Conditions. I confirm that I am legally authorized to use this platform and that I will comply with all applicable South African laws, including the Firearms Control Act (60), 2020. I understand that I am solely responsible for ensuring compliance with all relevant regulations and laws.</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <input type="submit" class="btn btn-primary" value="List Item">    
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function triggerFileInput(elem){
            const input = elem.querySelector('input[type="file"]');
            input.click();
        }
        document.addEventListener('livewire:initialized', () => {
            @this.on('go-to-top', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
    @endpush
</div>