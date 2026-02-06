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
                <div class="card-body py-0">
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
                <div>
                    <hr> 
                </div>
                @endif
                <div class="card-body py-0"> 
                    <small class="text-muted">Company Name</small>
                    <h6 class="bold">{{ $dealer->business_name }}</h6>

                    <small class="text-muted">Registration Number</small>
                    <h6 class="bold">{{ $dealer->business_reg_number }}</h6>

                    <small class="text-muted">vat Number</small>
                    <h6 class="bold">{{ $dealer->vat_number }}</h6>

                    <small class="text-muted">License Number</small>
                    <h6 class="bold">{{ $dealer->license_number }}</h6>

                    <small class="text-muted">Stocking Fee</small>
                    <h6 class="bold">R {{ number_format($dealer->dealer_stocking_fee, 2) }}</h6>

                    <small class="text-muted">Address</small>
                    <h6 class="bold">{!! $dealer->street.',<br />'.$dealer->suburb.',<br />'.$dealer->town.',<br />'.$dealer->province.',<br />'.$dealer->postal_code !!}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="card-title">Dealer Details</h4>
                        <div class="ms-auto">
                            @if($dealer->status == 0)
                                <a href="#" class="btn btn-primary btn-sm" wire:click.prevent="changeStatus(1)">Activate</a>
                            @else
                                <a href="#" class="btn btn-danger btn-sm" wire:click.prevent="changeStatus(0)">Disable</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div><hr /></div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Vendor</th>
                                <th>Buyer</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sels AS $sel)
                            <tr>
                                <td>
                                    @if($sel->product->images->count() > 0)
                                        <img style="height: 50px" src="{{ asset('storage/'.$sel->product->images->first()->image_url) }}" alt="Card image cap">
                                    @endif
                                </td>
                                <td>{{ $sel->vendor->name }}</td>
                                <td>{{ $sel->user->vendor->name }}</td>
                                <td>{{ $sel->product->item_name }}</td>
                                <td>{{ $sel->quantity }}</td>
                                <td>{{ date('d M Y', strtotime($sel->created_at)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>