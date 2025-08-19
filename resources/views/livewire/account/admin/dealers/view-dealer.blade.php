<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>AB DEALER NETWORK</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                @if($vendor)
                <div class="card-body">
                    <center class="m-t-30">
                        @if($vendor->avatar) 
                        <img src="{{ asset('storage/'.$vendor->avatar) }}" class="img-circle" width="150">
                        @else
                        <img src="{{ asset('img/logo-placeholder.webp') }}" class="img-circle" width="150">
                        @endif
                        <h4 class="card-title m-t-10">{{ $vendor->name }}</h4>
                        <h6 class="card-subtitle">{{ $vendor->description }}</h6>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-6"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                            <div class="col-6"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                        </div>
                    </center>
                </div>
                <div>
                    <hr> 
                </div>
                @endif
                <div class="card-body"> 
                    <small class="text-muted">Company Name</small>
                    <h6>{{ $dealer->business_name }}</h6>

                    <small class="text-muted">License Number</small>
                    <h6>{{ $dealer->license_number }}</h6>

                    <small class="text-muted">Stocking Fee</small>
                    <h6>R {{ number_format($dealer->dealer_stocking_fee, 2) }}</h6>

                    <small class="text-muted">Address</small>
                    <h6>{{ $dealer->business_street.', '.$dealer->business_suburb.', '.$dealer->business_city.', '.$dealer->business_province.', '.$dealer->business_postal_code }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>