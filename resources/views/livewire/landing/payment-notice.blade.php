<div>
    <style>
        .custom-callout {
            background-color: #f8f9fa; /* Light gray background matching the image */
            border-left: 4px solid #e04f1a !important; /* Thick orange left border */
            border-color: #dee2e6; /* Soft border color for top, right, bottom */
        }
        .custom-orange-icon {
            color: #e04f1a; /* Matching orange color for the shield icon */
        }
        .text-orange{
            color: #e04f1a;
        }
    </style>
    <div class="section" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card auth-cont">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center mb-5">
                                    @if($status == "successful")
                                        <div class="">
                                            <span class="fa-stack fa-2x">
                                                <i class="fas fa-circle fa-stack-2x" style="color: #198754;"></i>
                                                <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </div>
                                        <div class="mt-3">
                                            <h4 class="page-title">Payment successful</h4>
                                        </div>
                                        <div class="mt-3">
                                            <p>Order <b>{{ $order_no }}</b> - a receipt is on its way to your email</p>
                                        </div>
                                        <div class="mt-3">
                                            <div class="custom-callout p-3 rounded-end border border-start-0 d-flex align-items-start gap-3">
                                                <i class="fa fa-shield-alt custom-orange-icon fs-4 flex-shrink-0"></i>
                                                <div class="text-start">
                                                    <h6 class="fw-bold text-dark mb-1">Your payment is safe in escrow</h6>
                                                    <p class=" mb-0 small">
                                                        We've notified the seller. Your funds are held securely and only released once you confirm your item has arrived as described — so you're protected until then.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-start">
                                            <div class="card">
                                                <div class="card-header text-end">
                                                    <h6 class="fw-bold text-dark mb-1">Vendor: {{ $order->vendor->name }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Item</th>
                                                                <th>Description</th>
                                                                <th class="text-end">Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order->items AS $itm)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ asset('storage/'.$itm->product->images->first()->image_url) }}" style="width: 50px;">
                                                                </td>
                                                                <td>{{ $itm->product->item_name }}</td>
                                                                <td>{{ $itm->product->item_description }}</td>
                                                                <td class="text-end"><b>R {{ number_format($itm->product->item_price,2) }}</b></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-start">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h6 class="fw-bold text-orange">Step 1</h6>
                                                            <h6 class="fw-bold">Seller Ships</h6>
                                                            <p>You'll receive tracking.<br />&nbsp;</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h6 class="fw-bold text-orange">Step 2</h6>
                                                            <h6 class="fw-bold">You receive & inspect</h6>
                                                            <p>Check it matches.<br />&nbsp;</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h6 class="fw-bold text-orange">Step 3</h6>
                                                            <h6 class="fw-bold">You confirm</h6>
                                                            <p>We release funds to the seller.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 mb-5 text-center d-grid">
                                            <a href="{{ url('shop') }}" class="btn btn-secondary">Continue Shopping</a>
                                        </div>
                                    @else
                                        <div class="">
                                            <span class="fa-stack fa-2x">
                                                <i class="fas fa-circle fa-stack-2x" style="color: #dc3545;"></i>
                                                <i class="fa fa-exclamation fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </div>
                                        <div class="mt-3">
                                            <h4 class="page-title">Payment unsuccessful</h4>
                                        </div>
                                        <div class="mt-3">
                                            <p>No charge was made and your cart is saved — you can try again.</p>
                                        </div>
                                        <div class="mt-5 mb-5 text-center d-grid">
                                            <a href="{{ url('cart') }}" class="btn btn-secondary">Try again</a>
                                        </div>
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