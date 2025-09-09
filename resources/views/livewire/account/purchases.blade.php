<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="page-title bold">MY PURCHASES</h3>
                    @if($orders->count() > 0)
                    <div class="row mt-3 table-responsive">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                @foreach($orders AS $order)
                                <thead>
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Seller</th>
                                        <th>Payment Ref</th>
                                        <th class="text-end">AB Fee</th>
                                        <th class="text-end">Shipping Fee</th>
                                        <th class="text-end">Cart Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->vendor->name }}</td>
                                        <td>{{ $order->g_payment_id }}</td>
                                        <td class="text-end">R{{ number_format($order->ab_fee(), 2) }}</td>
                                        <td class="text-end">R{{ number_format($order->shiping_fee(),2) }}</td>
                                        <td class="text-end">R {{ number_format($order->cart_total, 2) }}</td>
                                    </tr>
                                    @if($order->items->count() > 0)
                                    <tr>
                                        <td colspan="6" class="p-0">
                                            <table class="table m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-end">Price</th>
                                                        <th class="text-end">Shipping</th>
                                                        <th class="text-end">Service Fee</th>
                                                        <th class="text-end">Total</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->items AS $item)
                                                    @php
                                                    $tot = $item->price + $item->shipping_price + $item->service_fee;

                                                    @endphp
                                                    <tr>
                                                        <td>{{ ucwords($item->product->item_name) }}</td>
                                                        <td class="text-center">{{ $item->quantity }}</td>
                                                        <td class="text-end">R {{ number_format($item->price,2) }}</td>
                                                        <td class="text-end">R {{ number_format($item->shipping_price,2) }}</td>
                                                        <td class="text-end">R {{ number_format($item->service_fee,2) }}</td>
                                                        <td class="text-end">R {{ number_format($tot, 2) }}</td>
                                                        <td>
                                                            @if(!$item->vendor_status && !$item->buyer_status)
                                                                <span class="badge bg-warning">Pending</span>
                                                            @elseif($item->vendor_status && !$item->buyer_status)
                                                                <span class="badge bg-info">Awaiting Buyer</span>
                                                            @elseif(!$item->vendor_status && $item->buyer_status)
                                                                <span class="badge bg-info">Awaiting Seller</span>
                                                            @elseif($item->vendor_status && $item->buyer_status)
                                                                <span class="badge bg-success">Complete</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="{{ url('messages/item?order-item='.$item->id) }}"><i class="icon-envelope"></i></a>
                                                            <span class="text-muted">&nbsp;|&nbsp;</span>
                                                            <a href="#" wire:click.prevent="showItemDetailsModal({{ $item->id }})"><i class="icon-eye"></i> View</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center mt-5">
                                <h1 class="text-muted">Get started</h1>
                                <p>Your purchases will show here.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="show-item-details">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Item Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($cur_item)
                        <ul class="list-group">
                            <li class="list-group-item d-flex">
                                <span>Item Name</span>
                                <div class="ms-auto"><b>{{ $cur_item->product->item_name }}</b></div>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>Price</span>
                                <div class="ms-auto"><b>R {{ number_format($cur_item->price,2) }}</b></div>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>Qty</span>
                                <div class="ms-auto"><b>{{ $cur_item->quantity }}</b></div>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>Settlement type</span>
                                <div class="ms-auto"><b>{{ ucwords($cur_item->deliver_collection) }}</b></div>
                            </li>
                            @if($cur_item->shipping_price)
                            <li class="list-group-item d-flex">
                                <span>Shipping Price</span>
                                <div class="ms-auto"><b>{{ number_format($cur_item->shipping_price,2) }}</b></div>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>Courier</span>
                                <div class="ms-auto"><b>{{ $cur_item->courier->type }}</b></div>
                            </li>
                            @endif
                            @if($cur_item->delivery_address)
                            <li class="list-group-item d-flex">
                                <span>Delivery Address</span>
                                <div class="ms-auto"><b>{!! $cur_item->delivery_address !!}</b></div>
                            </li>
                            @endif
                            @if($cur_item->deliver_collection == "dealer stock")
                            <li class="list-group-item d-flex">
                                <span>Dealer Details</span>
                                @if($cur_item->dealer_option == "ab dealer")
                                    <div class="ms-auto">
                                        <b>
                                            {{ $cur_item->dealer->business_name }}<br />
                                            {{ $cur_item->dealer->license_number }}<br /><br/>
                                            {{ $cur_item->dealer->business_street }}<br />
                                            {{ $cur_item->dealer->business_suburb }}<br />
                                            {{ $cur_item->dealer->business_city }}<br />
                                            {{ $cur_item->dealer->business_province }}<br />
                                            {{ $cur_item->dealer->business_postal_code }}<br />
                                        </b>
                                    </div>
                                @else
                                <div class="ms-auto"><b>{{ $cur_item->custom_dealer_details }}</b></div>
                                @endif
                            </li>
                            @endif
                            @if($cur_item->deliver_collection == "collection")
                            <li class="list-group-item">
                                <small><b>Note:</b> Please contact buyer to arrange collection.</small>
                            </li>
                            @endif
                            @if($cur_item->deliver_collection == "seller delivery")
                            <li class="list-group-item">
                                <small><b>Note:</b> Please contact buyer to arrange delivery.</small>
                            </li>
                            @endif
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @if($cur_item)
                        @if(!$cur_item->buyer_status && $show_action_btn)
                            <button type="button" class="btn btn-primary" wire:click.prevent="markOrderShipped({{ $cur_item->id }})">{{ $action_text }}</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-item-details-modal', () => {
                $('#show-item-details').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            });
        });
    </script>
    @endpush
</div>