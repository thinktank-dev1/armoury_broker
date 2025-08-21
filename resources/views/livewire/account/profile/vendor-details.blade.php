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
                    <form class="form-horizontal form-material" wire:submit.prevent="saveVendor">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12">Vendor Name</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="name" wire:model.defer="name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12">Description</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control form-control-line" name="decription" wire:model.defer="decription"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Tel</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="tel" wire:model.defer="tel">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="email" wire:model.defer="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Street</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="street" wire:model.defer="street">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Suburb</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="suburb" wire:model.defer="suburb">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">City</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="city" wire:model.defer="city">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Country</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="country" wire:model.defer="country">
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