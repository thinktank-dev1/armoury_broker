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
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="profile-pic">
                                            @if(Auth::user()->vendor)
                                                @if(Auth::user()->vendor->avatar)
                                                    <img src="{{ asset('storage/'.Auth::user()->vendor->avatar) }}" class="circle img-fluid" width="150">
                                                @else
                                                    <img src="{{ asset('img/avatar_placeholder_large.png') }}" class="circle img-fluid" width="150">
                                                @endif
                                            @else
                                                <img src="{{ asset('img/avatar_placeholder_large.png') }}" class="circle img-fluid" width="150">
                                            @endif
                                            <span class="edit-btn">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#avatar-edit-modal"><i class="icon-pencil"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="mb-3">
                                    <label class="form-label">Vendor Name</label>
                                    <input type="tetx" class="form-control" name="name" wire:model.defer="name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" wire:model.defer="description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Instagram Handle</label>
                                    <input type="text" class="form-control" name="instagram_handle" wire:model.defer="instagram_handle">
                                </div>
                            </div>                            

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nearest Town</label>
                                    <input type="text" class="form-control" name="city" wire:model.defer="city">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Province</label>
                                    <select class="form-control" name="province" wire:model.defer="province">
                                        <option value="">Select Option</option>
                                        @foreach($provinces AS $province)
                                        <option value="{{ $province }}">{{ $province }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Dealer Network Status</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(Auth::user()->dealer)
                                            Registered dealer
                                        @else
                                            Not a registered dealer
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a class="btn btn-secondary" wire:click.prevent="activateDealerTab">
                                            @if(Auth::user()->dealer)
                                                View dealer details
                                            @else
                                                Join dealer network
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <input type="submit" class="btn btn-primary" value="Update Details">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="avatar-edit-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Avatar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Select Avatar</label>
                                <input type="file" class="form-control" name="avatar" wire:model.defer="avatar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveAvater">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>