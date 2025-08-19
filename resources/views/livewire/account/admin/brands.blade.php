<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12 d-flex">
            <div class="">
                <h2>BRANDS</h2>
            </div>
            <span class="ms-auto">
                <a href="#" class="btn btn-primary" wire:click.prevent="showEdit">Add Brand</a>
            </span>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Brands</h5>
                    <div class="message-box ps ps--theme_default ps--active-y" id="task2">
                        <div class="message-widget message-scroll">
                            @foreach($brands AS $brand)
                            <a href="#" wire:click.prevent="showEdit({{ $brand->id }})">
                                <div class="user-img"> 
                                    @if($brand->brand_logo)
                                    <img src="{{ asset('storage/'.$brand->brand_logo) }}" alt="brand" class="img-circle"> 
                                    @else
                                    <span class="round">{{ mb_substr($brand->brand_name, 0,1) }}</span>
                                    @endif
                                </div>
                                <div class="mail-contnet">
                                    <h5>{{ $brand->brand_name }}</h5> 
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                            <div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__scrollbar-y-rail" style="top: 0px; height: 430px; right: 0px;">
                            <div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 348px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="form-modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Brands</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="row my-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form wire:submit.prevent="saveBrand">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" name="brand_name" wire:model.defer="brand_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Brand Logo</label>
                                    <input type="file" class="form-control" name="brand_logo" wire:model.defer="brand_logo">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="featured" name="featured" wire:model.defer="featured">
                                        <label class="form-check-label" for="featured">
                                            Featured
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveBrand">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-form-modal', () => {
                $('#form-modal').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            })
        })
    </script>
    @endpush
</div>