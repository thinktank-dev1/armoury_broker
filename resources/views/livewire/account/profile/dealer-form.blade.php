<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (session('status'))
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form class="form-horizontal form-material" wire:submit.prevent="saveDealer">
                        <div class="col-md-12 mb-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="dealer_stock_service" value="" name="dealer_stock_service" wire:model.live="dealer_stock_service">
                                <label class="form-check-label" for="dealer_stock_service">
                                    Do you offer dealer stocking as a service? 
                                </label>
                            </div>
                        </div>
                        @if($dealer_stock_service)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="join_dealer_network" wire:model.live="join_dealer_network">
                                        <label class="form-check-label" for="join_dealer_network">
                                            Would you like to join our dealer network?
                                        </label>
                                    </div>
                                </div>
                                <p><small>As part of our firearms sales process, dealer stocking may be required. We're building a network of certified dealers to facilitate this service.</small></p>
                                <b>How it works</b>
                                <p>
                                    <small>
                                        <ul>
                                            <li>Seller nomination - When listing firearms, sellers can nominate you as their preferred dealer</li>
                                            <li>Buyer connection - After purchase, buyers coordinate with sellers to arrange dealer stocking and receive your business details</li>
                                            <li>Service arrangement - You can set a monthly fee on the platform and collect fees directly with buyers for this service</li>
                                        </ul>
                                    </small>
                                </p>
                                <b>Fees</b>
                                <small>
                                    <p>
                                        Set your own monthly dealer stocking fee<br/>
                                        Armoury Broker charges dealers 5% on successful referrals (monthly billing for "dealer stocked" sales)<br/>
                                        Sales are marked as complete when items are released to buyers.
                                    </p>
                                </small>
                            </div>
                        @endif
                        @if($join_dealer_network)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Business Name</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="business_name" wire:model.defer="business_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Business Registration Number</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="business_reg_number" wire:model.defer="business_reg_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">VAT Number</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="vat_number" wire:model.defer="vat_number">
                                    </div>
                                </div>
                            </div>                           
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Fire Arms Dealer License Number</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="license_number" wire:model.defer="license_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Street</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="street" wire:model.defer="street">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Suburb</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="suburb" wire:model.defer="suburb">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Town</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="town" wire:model.defer="town">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Postal Code</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="postal_code" wire:model.defer="postal_code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Province</label>
                                    <div class="col-md-12">
                                        <select class="form-control form-control-line" name="province" wire:model.defer="province">
                                            <option value="">Select Option</option>
                                            @foreach($provinces AS $pr)
                                            <option value="{{ $pr }}">{{ $pr }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Billing contact</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="billing_contact" wire:model.defer="billing_contact">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Billing Contact Number</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="billing_contact_number" wire:model.defer="billing_contact_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-12">Billing Email</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="billing_email" wire:model.defer="billing_email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Dealer Stocking Fee</label>
                                    <div class="col-md-12 input-group">
                                        <span class="input-group-text">R</span>
                                        <input type="text" style="padding-left: 10px" class="form-control form-control-line" name="dealer_stocking_fee" wire:model.defer="dealer_stocking_fee">
                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->dealer)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="opt_out_dealer_network" wire:model.live="opt_out_dealer_network">
                                        <label class="form-check-label" for="opt_out_dealer_network">
                                            Would you like to opt out of our dealer network?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-12 mt-3">
                                <input type="submit" class="btn btn-primary" value="Update Details">
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('go-to-top', () => {
                $("html, body").animate({ scrollTop: 0 }, "slow");
            });
            @this.on('show-opt-out-confirmation', () => {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    // icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#293c47",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, opt out!"
                }).then((result) => {
                    if (result.value == true) {
                        @this.dispatch('opt-out-confirmed');
                        Swal.fire({
                            title: "Success!",
                            text: "You have been removed from dealer network list.",
                            // icon: "success"
                        });
                    }
                });
            })
        });
    </script>
    @endpush
</div>