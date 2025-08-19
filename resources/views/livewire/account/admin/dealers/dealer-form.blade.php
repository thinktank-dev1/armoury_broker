<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>AB DEALER NETWORK</h2>
        </div>
    </div>
    <form wire:submit.prevent="saveDealer" class="form-material m-t-40">
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Street</label>
                                    <input type="text" class="form-control" placeholder="Business Street" name="business_street" wire:model.defer="business_street">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Suburb</label>
                                    <input type="text" class="form-control" placeholder="Business Suburb" name="business_suburb" wire:model.defer="business_suburb">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" placeholder="Business City" name="business_city" wire:model.defer="business_city">
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                    <input type="text" class="form-control" placeholder="Dealer Stocking Fee" name="dealer_stocking_fee" wire:model.defer="dealer_stocking_fee">
                                </div>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-grid mb-5">
                <input type="submit" class="btn btn-primary" wire:click.prevent="saveDealer" value="SAVE">
            </div>
        </div>
    </form>
</div>