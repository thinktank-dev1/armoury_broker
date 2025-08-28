<div>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="m-t-30"> 
                            <div class="profile-pic">
                                @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/'.Auth::user()->avatar) }}" class="img-circle" width="150">
                                @else
                                <img src="{{ asset('img/avatar_placeholder_large.png') }}" class="img-circle" width="150">
                                @endif
                                <span class="edit-btn">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#avatar-edit-modal"><i class="icon-pencil"></i></a>
                                </span>
                            </div>
                            <h4 class="card-title m-t-10">{{ Auth::user()->name.' '.Auth::user()->surname }}</h4>
                            <h6 class="card-subtitle">
                                @if(Auth::user()->vendor)
                                {{ Auth::user()->vendor->name }}
                                @endif
                            </h6>
                            @if(Auth::user()->vendor)
                            <div class="row text-center justify-content-md-center">
                                <div class="col-6"><a href="javascript:void(0)" class="link"><i class="icon-like"></i> <font class="font-medium">{{ Auth::user()->vendor->likes->count() }}</font></a></div>
                                <div class="col-6"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">{{ Auth::user()->vendor->products->count() }}</font></a></div>
                            </div>
                            @endif
                        </center>
                    </div>
                    <div>
                        <hr> 
                    </div>
                    <div class="card-body"> 
                        <small class="text-muted">Email address </small>
                        <h6>{{ Auth::user()->email }}</h6> 
                        <small class="text-muted p-t-30 db">Phone</small>
                        <h6>{{ Auth::user()->mobile_number }}</h6> 
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <ul class="nav nav-tabs profile-tab" role="tablist" wire:ignore>
                        <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab" aria-selected="true">Profile</a> </li>
                        @if(Auth::user()->vendor_id)
                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="false">Vendor</a> </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home" role="tabpanel" wire:ignore.self>
                            <livewire:account.profile.profile-form />
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel" wire:ignore.self>
                            <livewire:account.profile.vendor-details />
                        </div>
                    </div>
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
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            });
        });
    </script>
    @endpush
</div>
