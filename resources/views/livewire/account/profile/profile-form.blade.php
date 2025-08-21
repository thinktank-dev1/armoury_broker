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
                    <form class="form-horizontal form-material" wire:submit.prevent="saveUser">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Name</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="name" wire:model.defer="name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Surname</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="surname" wire:model.defer="surname">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12">Mobile Number</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" name="mobile_number" wire:model.defer="mobile_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" class="form-control form-control-line" name="email" wire:model.defer="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12">Password</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control form-control-line" name="password" wire:model.defer="password">
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
