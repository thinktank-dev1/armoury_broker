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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Business Name</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="business_name" wire:model.defer="business_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Business Registration Number</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="business_reg_number" wire:model.defer="business_reg_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                        <input type="text" class="form-control form-control-line" name="province" wire:model.defer="province">
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
                            <div class="col-md-12 mt-3">
                                <input type="submit" class="btn btn-primary" value="Update Details">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>