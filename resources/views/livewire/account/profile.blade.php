<div>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3 class="page-title bold">
                    @if(url()->current() != URL::previous())
                    <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                    @endif
                    SETTINGS
                </h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <ul class="nav nav-tabs profile-tab settings-tabs" role="tablist" wire:ignore.self>
                        <li class="nav-item" wire:ignore> <a class="nav-link active" data-bs-toggle="tab" href="#armoury" role="tab" aria-selected="true">My Armoury</a> </li>
                        <li class="nav-item" wire:ignore> <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="false">My Profile</a> </li>
                        <li class="nav-item" wire:ignore> <a class="nav-link" data-bs-toggle="tab" href="#banking" role="tab" aria-selected="false">My Banking</a> </li>
                        <li class="nav-item" wire:ignore> <a class="nav-link" data-bs-toggle="tab" data-bs-target="#dealer" href="#dealer" id="dealer-link" role="tab" aria-selected="false">Dealer Network</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="armoury" role="tabpanel" wire:ignore.self>
                            <livewire:account.profile.vendor-details />
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel" wire:ignore.self>
                            <livewire:account.profile.profile-form />
                        </div>
                        <div class="tab-pane" id="banking" role="tabpanel" wire:ignore.self>
                            <livewire:account.profile.banking-details />
                        </div>
                        <div class="tab-pane" id="dealer" role="tabpanel" wire:ignore.self>
                            <livewire:account.profile.dealer-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function(){
            var hash = window.location.hash;
            if(hash) {
                var tabTrigger = document.querySelector('[data-bs-target="' + hash + '"]');
                if (tabTrigger) {
                    var tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            }
            const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabLinks.forEach(function (link) {
                link.addEventListener('shown.bs.tab', function (event) {
                    history.replaceState(null, null, event.target.getAttribute('data-bs-target'));
                });
            });
        });
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            });
            @this.on('activate-dealer-tab', () => {
                $('.nav-tabs a[href="#dealer"]').tab('show');
            });
        });
    </script>
    @endpush
    {{--
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="m-t-30"> 
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
                            <h4 class="card-title m-t-10">{{ Auth::user()->name.' '.Auth::user()->surname }}</h4>
                            <h6 class="card-subtitle mt-1">
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
        </div>
    </div>
    --}}
</div>
