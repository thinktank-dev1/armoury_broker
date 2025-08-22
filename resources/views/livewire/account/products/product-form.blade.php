<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-material" wire:submit.prevent="saveProduct">
                        <h3>ITEM LISTING OPTIONS</h3>
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
                                <h3>UPLOAD ITEM</h3>
                                <b>Image Upload</b>
                                <p>Upload up to 6 images <span class="ms-5"><a href="#" class="text-black"><b>View image upload guide</b></a></span></p>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    @foreach($product_images AS $key => $value)
                                    <div class="col-md-2">
                                        <div class="img-cont d-flex justify-content-center align-items-center" onclick="triggerFileInput(this)">
                                            @if($value)
                                                @if($value->temporaryUrl())
                                                <img src="{{ $value->temporaryUrl() }}" class="img-responsive">
                                                @else
                                                <img src="{{ asset('storage/'.$value) }}" class="img-responsive">
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
                                <h3>ITEM DETAILS</h3>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input type="text" class="form-control" placeholder="Item Name" name="item_name" wire:model.defer="item_name"> 
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Model Number</label>
                                    <input type="text" class="form-control" placeholder="Model Number" name="model_number" wire:model.defer="model_number"> 
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label>Item Description</label>
                                    <textarea class="form-control" placeholder="Item Description" name="item_description" wire:model.defer="item_description"></textarea>
                                </div>
                            </div>
                            <div class="@if(count($sub_sub) > 0) col-md-4 @else col-md-6 @endif mt-3">
                                <div class="form-group">
                                    <label>Category</label>
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
                                    <label>Sub Category</label>
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
                                    <label>Sub Sub Category</label>
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
                                    <label>Brand</label>
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
                                    <label>Condition</label>
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
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" placeholder="Quantity" name="quantity" wire:model.defer="quantity"> 
                                </div>
                            </div>
                            @if($category)
                                @if($category->measurement_type)
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        @if($category->measurement_type == "caliber")
                                            <label>Caliber</label>
                                            <input type="text" class="form-control" name="size" wire:model.defer="size">
                                        @elseif($category->measurement_type == "size")
                                            <label>Size</label>
                                            <select class="form-control" name="size" wire:model.defer="size">
                                                <option value="">Select Option</option>
                                                @foreach($sizes AS $sz)
                                                <option value="{{ $sz }}">{{ $sz }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label>{{ ucwords($category->measurement_type) }}</label>
                                            <input type="text" class="form-control" name="size" wire:model.defer="size">
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endif
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3>SHIPPING</h3>
                                <p><small><b>Please Note:</b> To be managed outside of the platform by the Seller.</small></p>
                            </div>
                            @foreach($shipping_types AS $k => $shipping)
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Shipping Type / Courier Name</label>
                                            <input type="text" class="form-control" placeholder="Shipping Type / Courier Name" name="shipping_name" wire:model.defer="shipping_types.{{ $k }}.type">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Price</label>
                                            <input type="number" class="form-control" placeholder="Shipping Price" name="shipping_price" wire:model.defer="shipping_types.{{ $k }}.cost">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-md-12">
                                <a href="#" class="btn btn-secondary" wire:click.prevent="addShippingType">ADD MORE</a>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3>PLATFROM FEES</h3>
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
                                <h3>ITEM PRICE</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Item Price</label>
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