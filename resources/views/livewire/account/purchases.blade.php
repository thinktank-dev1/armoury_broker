<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>My Purchases</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Purchased Items</h4>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            @if($orders)
                            <table class="table table-striped">
                                @foreach($orders AS $order)
                                <thead>
                                    <tr>
                                        <th>Order No.</th>
                                        <th>Seller</th>
                                        <th>Payment Ref</th>
                                        <th class="text-end">Cart Total</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $order->vendor->name }}</td>
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
                                            @if($order->shipping_status == 1 && $order->receipt_status == 0)
                                            <a href="#" class="btn btn-primary" wire:click.prevent="setOrderReceived({{ $order->id }})">Order Received</a>
                                            @endif
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
                                <h1 class="text-muted">Nothing here</h1>
                                <p>Your purchases will show here when.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>