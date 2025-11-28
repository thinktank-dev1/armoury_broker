<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h3 class="page-title bold">
                @if(url()->current() != URL::previous())
                <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                @endif
                MY PURCHASES
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <a href="#" class="btn @if($filter == 'all_orders') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('all_orders')">All Orders</a>
            <a href="#" class="btn @if($filter == 'complete') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('complete')">Complete</a>
            <a href="#" class="btn @if($filter == 'pending_payement') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('pending_payement')">Pending Payment</a>
            <a href="#" class="btn @if($filter == 'pending_dispatch') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('pending_dispatch')">Pending Dispatch</a>
            <a href="#" class="btn @if($filter == 'dispatched') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('dispatched')">Dispatched</a>
        </div>
    </div>
    <div class="accordion" id="accordionOrders" wire:ignore.self>
        @foreach($orders AS $order)
        @php
        $collapsed = "collapsed";
        $expanded = "false";
        $show = '';
        if($loop->index == 0){
            $collapsed = '';
            $expanded = "true";
            $show = 'show';
        }
        @endphp
        <div class="accordion-item" wire:ignore.self>
            <h2 class="accordion-header" id="heading_{{ $order->id }}" wire:ignore.self>
                <button class="accordion-button {{ $collapsed }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $order->id }}" aria-expanded="{{ $expanded }}" aria-controls="collapse_{{ $order->id }}" wire:ignore.self>
                    <table class="table table-borderless mb-0 me-5">
                        <thead class="p-0 m-0">
                            <tr class="p-0 m-0">
                                <th class="p-0 m-0 w-14">{{ 'AB-ORD-'.str_pad($order->id, 4, '0', STR_PAD_LEFT) }}<br/><small>Order Number</small></th>
                                <th class="p-0 m-0 w-14">{{ $order->vendor->name }}<br/><small>Seller</small></th>
                                <th class="p-0 m-0 w-14">{{ $order->g_payment_id }}<br/><small>Payment Ref</small></th>
                                <th class="p-0 m-0 w-14">R {{ number_format($order->shiping_fee(),2) }}<br/><small>Shipping Fee</small></th>
                                <th class="p-0 m-0 w-14">R {{ number_format($order->ab_fee(), 2) }}<br/><small>Platform Fee (Buyer)</small></th>
                                <th class="p-0 m-0 w-14">R {{ number_format($order->amount_paid, 2) }}<br/><small>Amount</small></th>
                                <th class="p-0 m-0 w-14">
                                    @if($order->status == "COMPLETE")
                                        Paid
                                    @else
                                        Not Paid
                                    @endif
                                    <br/><small>Payment Status</small>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </button>
            </h2>
            <div id="collapse_{{ $order->id }}" class="accordion-collapse collapse {{ $show }}" aria-labelledby="heading_{{ $order->id }}" data-bs-parent="#accordionOrders" wire:ignore.self>
                <div class="accordion-body">
                    <div class="row order-list">
                        @foreach($order->items AS $item)
                        <div class="col-md-12 btm-border">
                            <div class="row align-items-stretch">
                                <div class="col-md-6 mt-3 d-flex flex-column be">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <b class="bold">Order Details</b>
                                        </div>
                                        @if($item->product->images->count() > 0)
                                        <div class="col-md-6">
                                            <div class="mt-3">
                                                <img src="{{ asset('storage/'.$item->product->images->first()->image_url) }}" class="img-responsive" style="max-height: 150px;">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="@if($item->product->images->count() > 0) col-md-6 @else col-md-12 @endif mt-3">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr><th class="p-0">Order date:</th><td class="p-0">{{ date('d M Y', strtotime($order->created_at)) }}</td></tr>
                                                    <tr><th class="p-0">Item Title:</th><td class="p-0">{{ $item->product->item_name }}</td></tr>
                                                    <tr><th class="p-0">Quantity:</th><td class="p-0">{{ $item->quantity }}</td></tr>
                                                    <tr><th class="p-0">Listed Price:</th><td class="p-0">R {{ number_format($item->product->item_price,2) }}</td></tr>
                                                    <tr><th class="p-0">Sold Price:</th><td class="p-0">R {{ number_format($item->price,2) }}</td></tr>
                                                    <tr><th class="p-0">Discount Applied:</th><td class="p-0">{{ $item->discount ?? 0 }} %</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="mt-auto">
                                        <div class="row">
                                            <div class="col-md-12 mt-3 d-grid">
                                                <a href="#" class="btn btn-secondary" wire:click.prevent="messageSeller({{ $item->id }})">Message Buyer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3 d-flex flex-column">
                                    <b class="bold">Order Status</b>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th class="text-end">Delivery Type</th>
                                                <td class="">
                                                    @if($item->shipping_method == "collection_delivery")
                                                        {{ ucwords(str_replace('_', ' / ',$item->shipping_method)) }}
                                                    @else
                                                        {{ ucwords(str_replace('_', ' ',$item->shipping_method)) }}
                                                    @endif
                                                    @if($item->dealer)
                                                        <br />
                                                        {{ $item->dealer->business_name }}<br />
                                                        {{ $item->dealer->province }}<br />
                                                        R {{ number_format($item->dealer->dealer_stocking_fee,2) }} pm<br />
                                                    @elseif($item->custom_dealer_details)
                                                        <br />
                                                        {{ $item->custom_dealer_details }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($item->shipping_method == 'courier')
                                                @if($item->shiping_service)
                                                <tr>
                                                    <th class="text-end">Delivery Service</th>
                                                    <td>{{ $item->shiping_service }}</td>
                                                </tr>
                                                @endif
                                                @if($item->tracking_number)
                                                <tr class="mb-1">
                                                    <th class="text-end">Tracking Number</th>
                                                    <td class="">
                                                        {{ $item->tracking_number }}
                                                    </td>
                                                </tr>
                                                @endif
                                            @endif
                                            <tr>
                                                <th class="text-end">Order Status</th>
                                                <td class="">
                                                    @if($item->vendor_status == "Canceled")
                                                        Canceled
                                                    @elseif($item->vendor_status == null && $item->buyer_staus == null)
                                                        Pending
                                                    @elseif($item->vendor_status == "Order Dispatched" && $item->buyer_status == null)
                                                        Awaiting buyer confirmation
                                                    @else
                                                        Complete
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-auto">
                                        <div class="d-grid gap-2">
                                            @if($item->vendor_status == "Order Dispatched" && $item->buyer_status == null)
                                            <a href="" class="btn btn-primary" wire:click.prevent="showReceiptConfirmation({{ $item->id }})">Item received</a>
                                            @endif
                                            @if($item->vendor_status == "Order Dispatched" && $item->buyer_status != 'Received')
                                            <b>Other Actions</b>
                                            <a href="" class="btn btn-outline-danger" wire:click.prevent="showDisputeModal({{ $item->id }}, {{ $item->vendor_id }})">I have an issue with this order</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="modal fade" id="dispute-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dispute Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="seveDispute">
                        <div class="row">
                            <div cass="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Please Enter Your Grievance Note</label>
                                    <textarea class="form-control" name="grievance" wire:model.defer="grievance"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="seveDispute">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="confirmation-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please confirm that item has been received.</p>
                </div>
                <div class="modal-footer d-grid">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, item has not been received</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="confirmedReceipt">Yes, Item has been received!</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="dispute-confirmation-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Disputed Logged</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your dispute has been logged, one of our agents will contact you as soon as possible</p>
                </div>
                <div class="modal-footer d-grid">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" wire:click.prevent="confirmedReceipt">Yes, Item has been received!</button> -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-confirm-receipt', () => {
                $('#confirmation-modal').modal('show');
            });
            @this.on('dispute-saved', () => {
                $('#dispute-confirmation-modal').modal('show');
                /*
                Swal.fire({
                    title: "Disputed Logged",
                    text: "Your dispute has been logged, one of our agent will contact you as soon as possible.",
                    icon: "success",
                    confirmButtonColor: "#293c47",
                });
                */
            })
            @this.on('show-item-details-modal', () => {
                $('#show-item-details').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            });
            @this.on('show-dispute-modal', () => {
                $('#dispute-modal').modal('show');
            })
        });
    </script>
    @endpush
</div>