<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>MY ARMOURY</h2>
        </div>
    </div>
    <form wire:submit.prevent="saveArmoury" class="form-material m-t-40">
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

        <div class="row">
            <div class="@if(!$dealer_stock_service) col-md-12 @else col-md-6 @endif">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title">My Armoury Details</h4>
                            </div>
                        </div>
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
                                    <label class="form-label">Cellphone Number</label>
                                    <input type="text" class="form-control" placeholder="Cellphone Number" name="tel" wire:model.defer="tel">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" wire:model.defer="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Add Your Instagram Handle</label>
                                    <input type="text" class="form-control" placeholder="Instagram Handle" name="instagram_handle" wire:model.defer="instagram_handle">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Street</label>
                                    <input type="text" class="form-control" placeholder="Street" name="street" wire:model.defer="street">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Suburb</label>
                                    <input type="text" class="form-control" placeholder="Suburb" name="suburb" wire:model.defer="suburb">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" placeholder="City" name="city" wire:model.defer="city">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" placeholder="Postal Code" name="postal_code" wire:model.defer="postal_code">
                                </div>
                            </div>
                            <div class="col-md-12">
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
                            <div class="col-md-12 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="dealer_stock_service" value="" name="dealer_stock_service" wire:model.live="dealer_stock_service">
                                    <label class="form-check-label" for="dealer_stock_service">
                                        Do you offer dealer stocking as a service? 
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($dealer_stock_service)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title">Armoury Broker Dealer Network</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="join_dealer_network" wire:model.live="join_dealer_network">
                                        <label class="form-check-label" for="join_dealer_network">
                                            Would you like to join our dealer network?
                                        </label>
                                    </div>
                                </div>
                                <p><small>This will allow sellers to nominate your business as their dealer stocking location for firearms sales. You will be able to charge a fee for this service.</small></p>
                            </div>
                            @if($join_dealer_network)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Business Name</label>
                                    <input type="text" class="form-control" placeholder="Business Name" name="business_name" wire:model.defer="business_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">License Number</label>
                                    <input type="text" class="form-control" placeholder="License Number" name="license_number" wire:model.defer="license_number">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Street</label>
                                    <input type="text" class="form-control" placeholder="Business Street" name="business_street" wire:model.defer="business_street">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Suburb</label>
                                    <input type="text" class="form-control" placeholder="Business Suburb" name="business_suburb" wire:model.defer="business_suburb">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" placeholder="Business City" name="business_city" wire:model.defer="business_city">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" placeholder="Business Postal Code" name="business_postal_code" wire:model.defer="business_postal_code">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Province</label>
                                    <select class="form-control" placeholder="Business Province" name="business_province" wire:model.defer="business_province">
                                        <option value="">Select Option</option>
                                        @foreach($provinces AS $province)
                                        <option value="{{ $province }}">{{ $province }}</option>
                                        @endforeach
                                    </select>
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
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="ab_dealer_network_agreement" wire:model.defer="ab_dealer_network_agreement">
                                    <label class="form-check-label" for="ab_dealer_network_agreement">
                                        I would like to be added to AB dealer network.
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="license_agreement" wire:model.defer="license_agreement">
                                    <label class="form-check-label" for="license_agreement">
                                        I have an active dealer license number
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="fee_agreement" wire:model.defer="fee_agreement">
                                    <label class="form-check-label" for="fee_agreement">
                                        I agree to be charged 5% monthly referral fee by AB for firearms stocked as a result of an AB transaction for the duration of the stocking timeline.
                                    </label>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-12 d-grid mb-5">
                <input type="submit" class="btn btn-primary" wire:click.prevent="saveArmoury" value="SAVE">
            </div>
        </div>
    </form>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('go-to-top', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
    @endpush
</div>