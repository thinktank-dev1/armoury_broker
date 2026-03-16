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
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <ul class="nav nav-tabs profile-tab settings-tabs flex-nowrap overflow-x-auto" role="tablist" wire:ignore.self style="white-space: nowrap;">
                        <li class="nav-item" wire:ignore> 
                            <a class="nav-link active" data-bs-toggle="tab" href="#armoury" role="tab" aria-selected="true">
                                <i class="icons-Army-Key d-md-none"></i>
                                <span class="d-none d-md-block">My Armoury</span>
                            </a> 
                        </li>
                        <li class="nav-item" wire:ignore> 
                            <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="false">
                                <i class="fa fa-user d-md-none"></i>
                                <span class="d-none d-md-block">My Profile</span>
                            </a> 
                        </li>
                        <li class="nav-item" wire:ignore> 
                            <a class="nav-link" data-bs-toggle="tab" href="#banking" role="tab" aria-selected="false">
                                <i class="mdi mdi-credit-card-multiple d-md-none"></i>
                                <span class="d-none d-md-block">My Banking</span>
                            </a> 
                        </li>
                        {{-- <li class="nav-item" wire:ignore> <a class="nav-link" data-bs-toggle="tab" data-bs-target="#dealer" href="#dealer" id="dealer-link" role="tab" aria-selected="false">Dealer Network</a> </li> --}}
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
</div>
