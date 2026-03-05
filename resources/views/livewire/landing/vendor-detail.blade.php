<div>
    <div class="section py-5 bg-grey" wire:ignore.self>
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-md-12 d-flex">
                    <a class="text-dark-blue" href="{{ URL::previous() }}">
                        <i class="fas fa-chevron-left"></i> &nbsp;&nbsp;Back
                    </a>
                    <div class="ms-auto d-flex gap-3">
                        <livewire:landing.partials.report-block :vendor_id="$vendor->id" />
                    </div>
                </div>
            </div>
            
            <div class="row d-none d-md-flex">
                @if($vendor->avatar)
                <div class="col-md-3 text-center">
                    <img src="{{ asset('storage/'.$vendor->avatar) }}" class="img-fluid img-circle">
                </div>
                @endif
                <div class="@if($vendor->avatar) col-md-9 @else col-md-12 @endif">
                    <div class="row">
                        <div class="col-12 col-md-8 text-center text-md-start mt-3">
                            <h3>{{ ucwords($vendor->name) }}</h3>
                            <div class="d-flex justify-content-around justify-content-md-start gap-5 mt-3">
                                <div class="text-dark-blue">
                                    <b>{{ $vendor->likes->count() }}</b> Likes
                                </div>
                                <div class="text-dark-blue">
                                    <b>{{ $vendor->sold() }}</b> Items Sold
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="text-dark-blue">{{ $vendor->description }}</p>
                            </div>
                            <div class="">
                                <p class="mb-0"><i class="ti ti-truck"></i> Usually delivers in <b>{{ $vendor->average_delivery_time() }} days</b></p>
                                <p class="mt-1"><i class="ti-location-pin"></i> {{ $vendor->city }}</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <livewire:landing.partials.share-block :vendor_id="$vendor->id" type="vendor-detail" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-md-none">
                <!-- Mobile View -->
                <div class="">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="profile-pic mt-2 mb-2">
                                <div class="d-flex justify-content-center">
                                    @if($vendor->avatar)
                                        <img src="{{ asset('storage/'.$vendor->avatar) }}" class="img-fluid img-circle" />
                                    @else
                                        <img src="{{ asset('img/PROFILE PIC.png') }}" class="img-fluid img-circle" />
                                    @endif
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <h3 class="bold mb-1">{{ ucwords($vendor->name) }}</h3>
                            <div class="d-flex justify-content-center mb-3">
                                <div class="me-4">
                                    <b>{{ $vendor->likes->count() }}</b> Likes
                                </div>
                                <div>
                                    <b>{{ $vendor->sold() }}</b> Sold
                                </div>
                            </div>
                            <div class="mt-2 text-small">
                                <div class="mb-1"><i class="ti-truck"></i> Delivers in <font class="font-medium">{{ $vendor->average_delivery_time() }} days</font></div>
                                <div><i class="ti-location-pin"></i> {{ $vendor->city }}</div>
                            </div>
                            <div class="mt-3 px-3">
                                <p class="text-dark-blue small">{{ $vendor->description }}</p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 pt-3 border-top">
                            <livewire:landing.partials.share-block :vendor_id="$vendor->id" type="vendor-detail" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section py-5">
        <div class="container">
            <div class="row mt-4 product_list">
                @foreach($products AS $product)
                    <livewire:landing.shop.partials.product-list-item wire:key="{{ $product->id.now() }}" :id="$product->id" />
                @endforeach
            </div>
        </div>
    </div>
</div>
