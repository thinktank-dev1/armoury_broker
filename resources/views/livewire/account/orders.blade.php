<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>My Orders</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Orders Items</h4>
                    <h6 class="card-subtitle"><b>Note:</b> click order shipped on order details to alert buyer order is on its way.</h6>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            @if($orders->count() > 0)
                            <table class="table table-striped">
                                @foreach($orders AS $order)
                                <thead>
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Buyer</th>
                                        <th>Payment Ref</th>
                                        <th class="text-end">Cart Total</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->user->name.' '.$order->user->surname }}</td>
                                        <td>{{ $order->g_payment_id }}</td>
                                        <td class="text-end">R {{ number_format($order->cart_total, 2) }}</td>
                                        <td class="text-center">
                                            @if($order->shipping_status == 1 && $order->receipt_status == 1)
                                            <span class="badge bg-success">Complete</span>
                                            @elseif($order->shipping_status == 0 && $order->receipt_status == 0)
                                            <span class="badge bg-warning">Pending</span>
                                            @elseif($order->shipping_status == 1 && $order->receipt_status == 0)
                                            <span class="badge bg-primary">Shipped</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-primary" wire:click.prevent="showShippingModal({{ $order->id }})">Shipping Details</a>
                                        </td>
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
                            @else
                            <div class="text-center mt-5">
                                <h1 class="text-muted">Get started</h1>
                                <p>Your orders will show here when buyers purchase them.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="shipping-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Shipping Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($cur_order)
                    <ul class="list-group">
                        <li class="list-group-item d-flex">
                            <span>Name:</span>
                            <span class="ms-auto"><b>{{ $cur_order->user->name.' '.$cur_order->user->surname }}</b></span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span>Contact Number:</span>
                            <span class="ms-auto"><b>{{ $cur_order->user->mobile_number }}</b></span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span>Email:</span>
                            <span class="ms-auto"><b>{{ $cur_order->user->email }}</b></span>
                        </li>
                        @if($cur_order->user->vendor)
                        <li class="list-group-item d-flex">
                            <span>Address:</span>
                            <span class="ms-auto text-end">
                                <b>
                                    {{ $cur_order->user->vendor->street }}<br />
                                    {{ $cur_order->user->vendor->suburb }}<br />
                                    {{ $cur_order->user->vendor->city }}<br />
                                    {{ $cur_order->user->vendor->country }}<br />
                                </b>
                            </span>
                        </li>
                        @else
                        Please contact buyer for delivery address
                        @endif
                    </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @if($cur_order)
                        @if($cur_order->shipping_status == 0)
                        <button type="button" class="btn btn-primary" wire:click.prevent="markOrderShipped({{ $cur_order->id }})">Order Shipped</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-order-modal', () => {
                $('#shipping-modal').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            });
        });
    </script>
    @endpush
</div>