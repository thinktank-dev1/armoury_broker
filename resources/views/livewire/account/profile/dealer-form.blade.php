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
                        <div class="col-md-12">
                            <h3>Join Our Dealer Network</h4>
                            <p>Under South African firearms legislation, all private firearm sales must be facilitated by a licensed firearms dealer, including the dealer stocking component of the transfer process.</p>
                            <p>We're building a network of licensed firearms dealers to provide this essential service to buyers and sellers on our platform.</p>
                            <h3>Why Register?</h3>
                            <p>Once verified, you'll be added to our preferred dealer list and gain:</p>
                            <ul>
                                <li><b>Increased exposure:</b> Visible to users across the platform seeking dealer stocking services in your area</li>
                                <li><b>Additional foot traffic:</b> Attract new clients who may become repeat customers</li>
                                <li><b>Complete control:</b> Set your own monthly dealer stocking fees</li>
                                <li><b>Direct payment:</b> Collect fees directly from buyers</li>
                            </ul>
                            <h3>How It Works</h3>
                            <p>When a seller lists a firearm on our platform, they have the option to  select a registered dealer from their local area to facilitate dealer stocking while the buyer is acquiring the necessary licensing for the firearm. If you're within their area, you'll appear as an available option.</p>
                            <p>After purchase, both the buyer and seller receive your business details to coordinate the dealer stocking arrangements. You set your <b><u>monthly rate</u></b> on the platform and manage the service directly with clients.</p>
                            <h3>Cost Structure</h3>
                            <ul>
                                <li><b>No registration fee:</b> Joining the network is completely free</li>
                                <li><b>Platform fee:</b> We charge 5% of your monthly dealer stocking rate for transactions facilitated through Armoury Broker, invoiced monthly while the firearm remains in stock</li>
                            </ul>
                            <h3>Getting Started</h3>
                            <p>Registration is simple. Our team will verify that your dealer license is current and valid, after which you'll be added to the network and can begin receiving referrals immediately.</p>
                        </div>
                        @if(!$join_dealer_network)
                        <div class="col-md-12 mb-5">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="join_dealer_network" wire:model.live="join_dealer_network">
                                    <label class="form-check-label" for="join_dealer_network">
                                        I Would like to join the Armoury Broker Dealer Network?
                                    </label>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="dealer_stock_service" value="" name="dealer_stock_service" data-bs-toggle="modal" data-bs-target="#no-opt-modal">
                                <label class="form-check-label" for="dealer_stock_service">
                                    No thanks 
                                </label>
                            </div>
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
                                    <label class="form-label">Billing contact Name</label>
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
                                    <label class="form-label">Dealer Stocking Fee ()</label>
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
                            <div class="col-md-12 mt-3 text-end">
                                <input type="submit" class="btn btn-primary" value="Update Details">
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="no-opt-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">THE ARMOURY BROKER DEALER NETWORK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>If you change your mind, please come back to this section of the platform and complete the registration process.</p>
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