<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12 d-flex">
            <div class="">
                <h2>PRODUCTS</h2>
            </div>
        </div>
    </div>
    @if($product->images->count() > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @php
                        $cnt = 0
                        @endphp
                        @foreach($product->images AS $image)
                        @php
                        $cnt += 1
                        @endphp
                        <div class="col-md-2 admin-product-img-cont"> 
                            <img src="{{ asset('storage/'.$image->image_url) }}" class="img-responsive radius">
                        </div>
                        @php
                        if($cnt == 6){
                            break;
                        }
                        @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <center class="m-t-30">
                                @if($vendor->avatar) 
                                <img src="{{ asset('storage/'.$vendor->avatar) }}" class="img-circle" width="150">
                                @else
                                <img src="{{ asset('img/logo-placeholder.webp') }}" class="img-circle" width="150">
                                @endif
                                <h4 class="card-title m-t-10">{{ $vendor->name }}</h4>
                                <h6 class="card-subtitle">{{ $vendor->description }}</h6>
                            </center>
                        </div>
                    </div>
                </div>
                <div>
                    <hr> 
                </div>
                <div class="card-body"> 
                    <small class="text-muted">Vendor Name</small>
                    <h6>{{ $vendor->name }}</h6>

                    <small class="text-muted">Telephone</small>
                    <h6>{{ $vendor->tel }}</h6>

                    <small class="text-muted">Email</small>
                    <h6>{{ $vendor->email }}</h6>

                    <small class="text-muted">Address</small>
                    <h6>{{ $vendor->street.', '.$vendor->suburb.', '.$vendor->city }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class=card>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-xs-6 b-r"> <strong>Item Name</strong>
                            <br>
                            <p class="text-muted">{{ $product->item_name }}</p>
                        </div>
                        <div class="col-md-3 col-xs-6 b-r"> <strong>Model Number</strong>
                            <br>
                            <p class="text-muted">{{ $product->model_number }}</p>
                        </div>
                        <div class="col-md-3 col-xs-6 b-r"> <strong>Price</strong>
                            <br>
                            <p class="text-muted">R <b>{{ number_format($product->item_price, 2) }}</b></p>
                        </div>
                        <div class="col-md-3 col-xs-6"> <strong>Listing Type</strong>
                            <br>
                            <p class="text-muted">{{ ucwords($product->listing_type) }}</p>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <p>{{ $product->item_description }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <small>Brand</small>
                                    <p class="m-0">
                                        @if($product->brand)
                                        {{ $product->brand->brand_name }}
                                        @endif
                                    </p>
                                </li>
                                <li class="list-group-item">
                                    <small>Category</small>
                                    <p class="m-0">@if($product->category) {{ $product->category->category_name }} @endif @if($product->subCategory) - {{ $product->subCategory->sub_category_name }} @endif @if($product->sub_sub) - {{ $product->sub_sub->sub_category_name }} @endif</p>
                                </li>
                                <li class="list-group-item">
                                    <small>Condition</small>
                                    <p class="m-0">{{ $product->condition }}</p>
                                </li>
                                <li class="list-group-item">
                                    <small>Quantity</small>
                                    <p class="m-0">{{ $product->quantity }}</p>
                                </li>
                                <li class="list-group-item">
                                    <small>Size</small>
                                    <p class="m-0">{{ $product->size }}</p>
                                </li>
                                <li class="list-group-item">
                                    <small>Service Fee Payer</small>
                                    <p class="m-0">{{ $product->service_fee_payer }}</p>
                                </li>
                                <li class="list-group-item">
                                    <small>Offers Allowed</small>
                                    <p class="m-0">@if($product->allow_offers) Yes @else No @endif</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>