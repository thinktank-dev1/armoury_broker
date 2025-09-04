<div class="h-100 mt-auto">
    @if($view_type == "vendor-detail")
    <div class="d-none d-md-flex align-items-end flex-column h-100">
        <div class="text-end d-flex flex-column gap-2 mt-auto mb-3">
            @if(!Auth::guest())
            <div class="">
                <a href="#" wire:click.prevent="likeVendor">
                    Like 
                    @if($vendor->likes->where('user_id', Auth::user()->id)->first())
                    <i class="fas fa-star"></i>
                    @else
                    <i class="icon-star"></i>
                    @endif
                </a>
            </div>
            @endif
            <div class="">
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#rightSidebar">
                    Share <i class="icon-share"></i>
                </a>
            </div>
            <div class="">
                <a href="#" wire:click.prevent="copyLink">
                    Copy Link <i class="icon-paper-clip"></i>
                </a>
            </div>
            <div class="">
                <a href="#" data-bs-toggle="modal" data-bs-target="#message-modal">
                    Message Seller <i class="icon-envelope"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row d-md-none">
        <div class="col-6">
            @if(!Auth::guest())
            <div class="">
                <a href="#" wire:click.prevent="likeVendor">
                    @if($vendor->likes->where('user_id', Auth::user()->id)->first())
                    <i class="fas fa-star"></i>
                    @else
                    <i class="icon-star"></i>
                    @endif
                    Like 
                </a>
            </div>
            @endif
            <div class="mt-3">
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#rightSidebar">
                    <i class="icon-share"></i> Share
                </a>
            </div>
        </div>
        <div class="col-6">
            <div class="text-end">
                <a href="#" wire:click.prevent="copyLink">
                    Copy Link <i class="icon-paper-clip"></i>
                </a>
            </div>
            <div class="mt-3 text-end">
                <a href="#" data-bs-toggle="modal" data-bs-target="#message-modal">
                    Message Seller <i class="icon-envelope"></i>
                </a>
            </div>
        </div>
    </div>
    @elseif($view_type == "product-detail")
    <div class="row mt-3">
        <div class="col-md-12 d-flex justify-content-between social-links-sm">
            <a href="{{ url($vendor->url_name) }}"><u>View Seller Profile</u></a>
            <span>
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#rightSidebar">
                    <span class="d-flex flex-column flex-md-row">
                        <span class="order-2 order-md-1">
                        Share
                        </span> 
                        <i class="icon-share order-1 order-md-2 ms-md-2 pt-md-1"></i>
                    </span>
                </a>
            </span>
            <span>
                <a href="#" wire:click.prevent="copyLink">
                    <span class="d-flex flex-column flex-md-row">
                        <span class="order-2 order-md-1">
                        Copy link 
                        </span>
                        <i class="icon-paper-clip order-1 order-md-2 ms-md-2 pt-md-1"></i>
                    </span>
                </a>
            </span>
            <span>
                <a href="#" data-bs-toggle="modal" data-bs-target="#message-modal">
                    <span class="d-flex flex-column flex-md-row">
                        <span class="order-2 order-md-1">
                            Message seller 
                        </span>
                        <i class="icon-envelope order-1 order-md-2 ms-md-2 pt-md-1"></i>
                    </span>
                </a>
            </span>
        </div>
    </div>
    @endif
    <div class="offcanvas offcanvas-end" tabindex="-1" id="rightSidebar">
        <div class="offcanvas-header bg-grey">
            <h5 class="offcanvas-title">Share Options</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="mt-5 mb-3 d-grid">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $link }}" target="_blank" class="btn btn-primary" style="background-color: #1877F2; padding: 14px 30px;">Share on Facebook</a>
            </div>
            <div class="mt-5 mb-3 d-grid">
                <a href="https://twitter.com/share?url={{ $link }}" target="_blank" class="btn btn-primary" style="background-color: #1DA1F2; padding: 14px 30px;">Share on X</a>
            </div>
            <div class="mt-5 mb-3 d-grid">
                <a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url={{ $link }}&title=&summary=" target="_blank" class="btn btn-primary" style="background-color: #0077B5; padding: 14px 30px;">Share on LinkedIn</a>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="message-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact {{ $vendor->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveMessage">
                        @if($errors->any())
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            @if(Auth::guest())
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" wire:model.defer="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Surname</label>
                                    <input type="text" class="form-control" name="surname" wire:model.defer="surname">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" wire:model.defer="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" name="contact_number" wire:model.defer="contact_number">
                                </div>
                            </div>
                            @endif
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" wire:model.defer="message"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveMessage">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('message-sent', () => {
                $('.modal').modal('hide');
                $.notify("Message has been sent", "success");
            });
            @this.on('copy-link', (event) => {
                var link = event.link;
                navigator.clipboard.writeText(link);
                $.notify("Link has been copied", "success");
            });
        });
    </script>
    @endpush
</div>
