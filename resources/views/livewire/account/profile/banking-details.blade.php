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
                    <form class="form-horizontal form-material" wire:submit.prevent="saveBankDetails">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" wire:model.defer="bank_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Branch Code</label>
                                    <input type="text" class="form-control" name="branch_code" wire:model.defer="branch_code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" name="account_number" wire:model.defer="account_number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" name="branch_name" wire:model.defer="branch_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Account Holder</label>
                                    <input type="text" class="form-control" name="account_holder" wire:model.defer="account_holder">
                                </div>
                            </div>
                            <div class="col-md-12 text-end mt-4">
                                <input type="submit" class="btn btn-primary" value="Update Details" wire:click.prevent="saveBankDetails">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>