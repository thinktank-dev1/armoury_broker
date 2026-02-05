<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h3 class="page-title bold">
                @if(url()->current() != URL::previous())
                <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                @endif
                MY ORDERS
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
                                <th class="p-0 m-0 w-14">{{ $order->user->vendor->name }}<br/><small>Buyer</small></th>
                                <th class="p-0 m-0 w-14">{{ $order->g_payment_id }}<br/><small>Payment Ref</small></th>
                                <th class="p-0 m-0 w-14">R {{ number_format($order->shiping_fee(),2) }}<br/><small>Shipping Fee</small></th>
                                <th class="p-0 m-0 w-14">R {{ number_format($order->ab_fee(), 2) }}<br/><small>Platform Fee (Buyer)</small></th>
                                <th class="p-0 m-0 w-14">R {{ number_format($order->amount_paid, 2) }}<br/><small>Amount Paid</small></th>
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
                                                    <tr><th class="p-0">Vendor:</th><td class="p-0"><a href="{{ url('/'.$item->product->vendor->url_name) }}"><strong>{{ $item->product->vendor->name }}</strong></a></td></tr>
                                                    <tr><th class="p-0">Order date:</th><td class="p-0">{{ date('d M Y', strtotime($order->created_at)) }}</td></tr>
                                                    <tr><th class="p-0">Item Title:</th><td class="p-0">{{ $item->product->item_name }}</td></tr>
                                                    <tr><th class="p-0">Quantity:</th><td class="p-0">{{ $item->quantity }}</td></tr>
                                                    <tr><th class="p-0">Listed Price:</th><td class="p-0">R {{ number_format($item->product->item_price,2) }}</td></tr>
                                                    @php
                                                    $sold_price = ($item->total_paid - $item->shipping_price - $item->service_fee) / $item->quantity;
                                                    @endphp
                                                    <tr><th class="p-0">Sold Price:</th><td class="p-0">R {{ number_format($sold_price,2) }}</td></tr>
                                                    <tr><th class="p-0">Discount Applied:</th><td class="p-0">{{ $item->discount ?? 0 }} %</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="mt-auto">
                                        <div class="row">
                                            <div class="col-md-12 mt-3 d-grid">
                                                <a href="#" class="btn btn-secondary" wire:click.prevent="messageBuyer({{ $item->id }})">Message Buyer</a>
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
                                            <tr class="mb-1">
                                                <th class="text-end">Deliver Service</th>
                                                <td class="">
                                                    <div class="input-group">
                                                        @if($item->vendor_status != "Canceled")
                                                        <select class="form-control" name="shiping_service" wire:model.defer="orders_items_arr.{{ $item->id }}.shiping_service">
                                                            <option value="">Select Option</option>
                                                            @foreach($services AS $sv)
                                                                <option value="{{ $sv->name }}">{{ $sv->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button class="btn btn-outline-secondary" type="button"  data-bs-toggle="modal" data-bs-target="#add-shipping-service">Add</button>
                                                        @else
                                                        {{ $item->shiping_service }}
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="mb-1">
                                                <th class="text-end">Tracking Number (optional)</th>
                                                <td class="">
                                                    <input type="text" class="form-control" name="tracking_number" wire:model.defer="orders_items_arr.{{ $item->id }}.tracking_number">
                                                </td>
                                            </tr>
                                            @endif
                                            @if($item->buyer_status != "Received")
                                            <tr>
                                                <th class="text-end">Shipping Status</th>
                                                <td class="py-3">
                                                    @if($item->vendor_status != "Canceled" && ($item->vendor_status != "Order Dispatched" || $item->vendor_status == 'Dealer stocked - Confirmed'))
                                                    <select class="form-control" name="vendor_status" wire:model.defer="orders_items_arr.{{ $item->id }}.vendor_status">
                                                        @if($item->dealer || $item->custom_dealer_details)
                                                        <option value="">Pending Dealer Stocking</option>
                                                        <option value="Firearm dealer stocked">Firearm Dealer Stocked</option> 
                                                        <option value="Dealer stocked - Confirmed">Dealer Stocked - Confirmed</option>   
                                                        @else 
                                                        <option value="">Pending Dispatch</option>
                                                        <option value="Order Dispatched">Order Dispatched</option>
                                                        @endif
                                                    </select>
                                                    @else
                                                        {{ $item->vendor_status }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th class="text-end">Order Status</th>
                                                <td class="">
                                                    @if($item->vendor_status == "Canceled")
                                                        Canceled
                                                    @elseif($item->vendor_status == null && $item->buyer_status == null)
                                                        Pending
                                                    @elseif($item->vendor_status == "Firearm dealer stocked")
                                                        Awaiting Firearm Dealer Stocked Confirmation
                                                    @elseif(($item->vendor_status == "Order Dispatched" || $item->vendor_status == 'Dealer stocked - Confirmed') && $item->buyer_status == null)
                                                        Awaiting Buyer Confirmation
                                                    @else
                                                        Complete
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="mt-auto">
                                        <div class="d-grid gap-2">
                                            <a href="" class="btn btn-primary" wire:click.prevent="updateOrderStatus({{ $item->id }})">Update</a>
                                            @if(($item->vendor_status != "Order Dispatched" || $item->vendor_status == 'Dealer stocked - Confirmed') && $item->vendor_status != "Canceled")
                                            <a href="" class="btn btn-outline-danger" wire:click.prevent="showCancelConfirmation({{ $item->id }})">Cancel Order</a>
                                            @endif
                                            <a href="" class="btn btn-outline-danger" wire:click.prevent="showDisputeModal({{ $item->id }}, {{ $item->vendor_id }})">I have an issue with this order</a>
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
    <div class="modal fade" tabindex="-1" id="add-shipping-service" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Shipping Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="row my-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form wire:submit.prevent="saveShipService">
                        <div class="mb-3">
                            <label class="form-label">Service Name</label>
                            <input type="text" class="form-control" name="shipping_service_name" wire:model.defer="shipping_service_name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveShipService">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="confirmation-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You will still remain liable for the full platform fee of 5% should this be implemented.</p>
                </div>
                <div class="modal-footer d-grid">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Don't Cancel Order</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="cancelOrder">Yes, Cancel Order!</button>
                </div>
            </div>
        </div>
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
    
    <div class="modal fade" tabindex="-1" id="order-edited-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Item Edited</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Order item has been successfully submitted.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('dispute-saved', () => {
                $('#dispute-confirmation-modal').modal('show');
            });
            @this.on('show-dispute-modal', () => {
                $('#dispute-modal').modal('show');
            })
            @this.on('show-cancel-confirmation', () => {
                $('#confirmation-modal').modal('show');
            });
            @this.on('show-item-details-modal', () => {
                $('#show-item-details').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            });
            @this.on('order-item-edited', () => {
                $('#order-edited-modal').modal('show');
            });
        });
    </script>
    @endpush
</div>