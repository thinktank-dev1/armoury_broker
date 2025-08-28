<div>
    <div class="section py-5 bg-grey">
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
            <div class="row">
                @if($vendor->avatar)
                <div class="col-md-3">
                    <img src="{{ asset('storage/'.$vendor->avatar) }}" class="img-fluid img-circle">
                    
                </div>
                @endif
                <div class="@if($vendor->avatar) col-md-9 @else col-md-12 @endif">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{ ucwords($vendor->name) }}</h3>
                            <div class="d-flex gap-5">
                                <div class="text-dark-blue">
                                    <b>{{ $vendor->likes->count() }}</b> Likes
                                </div>
                                <div class="text-dark-blue">
                                    <b>0</b> Items Sold
                                </div>
                            </div>
                            <div class="">
                                <p class="text-dark-blue">{{ $vendor->description }}</p>
                            </div>
                            <div class="">
                                <p class="mb-0"><i class="ti ti-truck"></i> Usually delivers in <b>0 days</b></p>
                                <p class="mt-1"><i class="ti-location-pin"></i> {{ $vendor->city }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
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
