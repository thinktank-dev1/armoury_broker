<div class="container-fluid">
    <div class="row mt-3">
        <!-- <div class="col-md-12">
            <h2>MY ARMOURY</h2>
        </div> -->
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if($errors->any())
            <div class="row mt-3 mb-3">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                </div>
            </div>
            @endif
            @if (session('status'))
            <div class="row mt-3 mb-3">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
            @endif
            @if (session('error'))
            <div class="row mt-3 mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if($view == "armoury")
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <h4 class="card-title">My Armoury Details</h4>
                    </div>
                    <div class="mt-3">
                        <form class="form-material m-t-40" wire:submit.prevent="saveArmoury">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Armoury Name</label>
                                        <input type="text" class="form-control" placeholder="Armoury Name" name="armoury_name" wire:model.defer="armoury_name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Armoury Biography</label>
                                        <textarea class="form-control" placeholder="Armoury Biography" name="bio" wire:model.defer="bio"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Add Your Instagram Handle</label>
                                        <input type="text" class="form-control" placeholder="Instagram Handle" name="instagram_handle" wire:model.defer="instagram_handle">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Suburb</label>
                                        <input type="text" class="form-control" placeholder="Suburb" name="suburb" wire:model.defer="suburb">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control" placeholder="City" name="city" wire:model.defer="city">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Province</label>
                                        <select class="form-control" placeholder="Province" name="province" wire:model.defer="province">
                                            <option value="">Select Option</option>
                                            @foreach($provinces AS $province)
                                            <option value="{{ $province }}">{{ $province }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Armoury Logo / Avatar</label>
                                        <input type="file" class="form-control" placeholder="Armoury Logo / Avatar" name="avatar" wire:model.defer="avatar">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p>We're building a network of licensed firearms dealers to provide dealer stocking services to buyers and sellers on our platform.</p>
                                    <p>Should you be a licensed firearms dealer and are interested in joining the network, please let us know below and we will send you some further information.</p>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="dealer_stock_service" value="dealer" name="dealer_stock_service" wire:model.live="dealer_stock_service">
                                        <label class="form-check-label" for="dealer_stock_service">
                                            I am a licensed firearms dealer and would like more info
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" id="no_dealer_stock_service" value="not-dealer" name="dealer_stock_service" wire:model.live="dealer_stock_service">
                                        <label class="form-check-label" for="no_dealer_stock_service">
                                            I am not a licensed firearms dealer
                                        </label>
                                    </div>
                                </div>
                                {{--
                                <div class="col-md-12 mb-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="dealer_stock_service" value="" name="dealer_stock_service" wire:model.live="dealer_stock_service">
                                        <label class="form-check-label" for="dealer_stock_service">
                                            Do you offer dealer stocking as a service? 
                                        </label>
                                    </div>
                                </div>
                                --}}
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" wire:click.prevent="saveArmoury" value="{{ $btn_text }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @elseif($view == "dealer")
                @if($dealer_stock_service)
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="card-title">Armoury Broker Dealer Network</h4>
                                </div>
                            </div>
                            <form class="form-material m-t-40" wire:submit.prevent="saveDealer">
                                <div class="row">
                                    <div class="col-md-12">                                       
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
                                        <div class="my-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="join_dealer_network" wire:model.live="join_dealer_network">
                                                <label class="form-check-label" for="join_dealer_network">
                                                    Would you like to join our dealer network?
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @if($join_dealer_network)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Registered Business Name</label>
                                            <input type="text" class="form-control" placeholder="Business Name" name="business_name" wire:model.defer="business_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Business Registration Number</label>
                                            <input type="text" class="form-control" placeholder="Business Registration Number" name="business_reg_number" wire:model.defer="business_reg_number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">VAT Number</label>
                                            <input type="text" class="form-control" placeholder="VAT Number" name="vat_number" wire:model.defer="vat_number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Fire Arms Dealer License Number</label>
                                            <input type="text" class="form-control" placeholder="License Number" name="license_number" wire:model.defer="license_number">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">What is your monthly fee for dealer stocking?</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">R</span>
                                                <input type="text" style="padding-left: 10px" class="form-control" placeholder="Dealer Stocking Fee" name="dealer_stocking_fee" wire:model.defer="dealer_stocking_fee">
                                            </div>
                                        </div>
                                        <p><small>This will be included on the network list, AB charges the dealer 5% of the monthly active stocking fees while a transaction is in progress</small></p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Street</label>
                                            <input type="text" class="form-control" placeholder="Street" name="street" wire:model.defer="d_street">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Suburb</label>
                                            <input type="text" class="form-control" placeholder="Suburb" name="suburb" wire:model.defer="d_suburb">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" placeholder="Town" name="town" wire:model.defer="d_town">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Postal Code</label>
                                            <input type="text" class="form-control" placeholder="Postal Code" name="postal_code" wire:model.defer="postal_code">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Province</label>
                                            <select class="form-control" placeholder="Province" name="province" wire:model.defer="d_province">
                                                <option value="">Select Option</option>
                                                @foreach($provinces AS $province)
                                                <option value="{{ $province }}">{{ $province }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Billing Contact Name</label>
                                            <input type="text" class="form-control" placeholder="Billing Contact Name" name="billing_contact" wire:model.defer="billing_contact">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Billing Contact Number</label>
                                            <input type="text" class="form-control" placeholder="Billing Contact Number" name="billing_contact_number" wire:model.defer="billing_contact_number">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="mb-3">
                                            <label class="form-label">Billing Email Address</label>
                                            <input type="text" class="form-control" placeholder="Billing Email Address" name="billing_email" wire:model.defer="billing_email">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="ab_dealer_network_agreement" wire:model.defer="ab_dealer_network_agreement">
                                            <label class="form-check-label" for="ab_dealer_network_agreement">
                                                I would like to be added to Armoury Broker dealer network.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="license_agreement" wire:model.defer="license_agreement">
                                            <label class="form-check-label" for="license_agreement">
                                                I have an active dealer license number.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="fee_agreement" wire:model.defer="fee_agreement">
                                            <label class="form-check-label" for="fee_agreement">
                                                I agree to be charged 5% monthly referral fee by Armoury Broker for firearms stocked as a result of an AB transaction for the duration of the stocking timeline.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="terms_agreement" wire:model.defer="terms_agreement">
                                            <label class="form-check-label" for="terms_agreement">
                                                I accept the <a href="{{ url('docs/Terms%20of%20Use%20and%20User%20Agreement_AB_Courier%20amendments_v02_20250629.pdf') }}" target="_blank">Terms & Conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="submit" class="btn btn-primary" wire:click.prevent="saveDealer" value="SAVE">
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="init-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Welcome to Armoury Broker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <h2>Hi {{ Auth::user()->name }}</h2>
                        <p>Thank you for joining our trusted community. You're now part of South Africa's leading secure marketplace transforming how firearms owners buy, sell, and trade equipment in a safe and secure environment.</p>
                        <p>You're currently viewing your ecommerce store dashboard—your central hub for accessing all platform features. The Dashboard tab in the left-hand menu provides an overview of your store with convenient shortcut links to navigate the entire platform. Getting around is simple: use either the left-hand menu tabs or the dashboard shortcuts.</p>
                        <p>Ready to start? Browse quality equipment from verified sellers, list your unused gear, or explore competitive prices with complete peace of mind.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="dealer-welcome-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Thanks for showing an interest in joining our Dealer Network! Once you have completed your Armoury setup and have done some exploring around the platform, you can take a look at the Dealers section, which is found under the Settings tab on the left hand menu for more information and a registration form to join the Armoury Broker Dealer Network”</p> 
                    <p>It is great to have you on the platform!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ url('profile/#dealer') }}" type="button" class="btn btn-primary">Continue</a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function(){
            var queryString = window.location.search;

            var urlParams = new URLSearchParams(queryString);
            if (urlParams.has('init')){
                $('#init-modal').modal('show');
            }
        })
        document.addEventListener('livewire:initialized', () => {
            @this.on('success-message', (e) => {
                $.toast({
                    heading: 'Success',
                    text: e.message,
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'success',
                    hideAfter: 3500, 
                    stack: 6
                });
            });
            @this.on('show-dealer-pop-up', () => {
                $('#dealer-welcome-modal').modal('show');
            });
            @this.on('go-to-top', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
    @endpush
</div>