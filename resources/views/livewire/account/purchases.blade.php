<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="page-title bold">MY PURCHASES</h3>
                    @if($orders->count() > 0)
                    <div class="row d-md-none">
                        <div class="co-md-12">
                            @foreach($orders AS $order)
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-sm-flex">
                                    <span class="text-muted">Order No</span>
                                    <div class="ms-auto">
                                        #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                </li>
                                <li class="list-group-item d-sm-flex">
                                    <span class="text-muted">Seller</span>
                                    <div class="ms-auto">
                                        {{ $order->vendor->name }}
                                    </div>
                                </li>
                                <li class="list-group-item d-sm-flex">
                                    <span class="text-muted">Payment Ref</span>
                                    <div class="ms-auto">
                                        {{ $order->g_payment_id }}
                                    </div>
                                </li>
                                <li class="list-group-item d-sm-flex">
                                    <span class="text-muted">Cart Total</span>
                                    <div class="ms-auto">
                                        R {{ number_format($order->cart_total, 2) }}
                                    </div>
                                </li>
                                <li class="list-group-item d-sm-flex">
                                    <span class="text-muted">Status</span>
                                    <div class="ms-auto">
                                        @if($order->shipping_status == 1 && $order->receipt_status == 1)
                                        <span class="badge bg-success">Complete</span>
                                        @elseif($order->shipping_status == 0 && $order->receipt_status == 0)
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif($order->shipping_status == 1 && $order->receipt_status == 0)
                                        <span class="badge bg-primary">Shipped</span>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="row mt-3 d-none d-md-block">
                        <div class="col-md-12">
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
</div>