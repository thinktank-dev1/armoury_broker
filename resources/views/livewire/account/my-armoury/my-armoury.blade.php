<div class="container-fluid">
    @if(Auth::user()->vendor)
    <div class="row">
        <div class="col-md-12 mt-3">
            <h3 class="page-title bold">
                @if(url()->current() != URL::previous())
                <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                @endif
                MY ARMOURY
            </h3>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">
            <div class="mb-3">
                <select class="form-control" name="listing_type" wire:model.live="listing_type">
                    <option value="">Filter By Listing Type</option>
                    <option value="sale">Sale</option>
                    <option value="wanted">Wanted</option>
                </select>
            </div>
            <div class="mb-3">
                <select class="form-control" name="category_id" wire:model.live="category_id">
                    <option value="">Filter By Category</option>
                    @foreach($cats AS $cat)
                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <select class="form-control" name="brand_id" wire:model.live="brand_id">
                    <option value="">Filter By Brands</option>
                    @foreach($brands AS $brand)
                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 d-grid">
                <a href="#" class="bnt btn-primary text-center" wire:click.prevent="clearFilters">Clear</a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body px-5">
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="{{ url('profile') }}">
                                        <center class="mt-3">
                                            @if(Auth::user()->vendor->avatar) 
                                            <img src="{{ asset('storage/'.Auth::user()->vendor->avatar) }}" class="circle img-fluid">
                                            @else
                                            <img src="{{ asset('img/PROFILE PIC.png') }}" class="img-circle img-fluid">
                                            @endif
                                        </center>
                                    </a>
                                </div>
                                <div class="col-md-10 text-center text-md-start">
                                    <h4 class="card-title m-t-10">{{ Auth::user()->vendor->name }} </h4>
                                    <h6 class="card-subtitle mt-2">{{ url(Auth::user()->vendor->url_name) }}</h6>
                                    <div>
                                        <a href="javascript:void(0)" class="link me-5"><i class="fas fa-star"></i> <font class="font-medium">{{ Auth::user()->vendor->likes->count() }}</font> Likes</a>
                                        <a href="javascript:void(0)" class="link"><i class="icon-grid"></i> <font class="font-medium">{{ Auth::user()->vendor->sold() }}</font> Items Sold</a>
                                    </div>
                                    <div class="mt-3">
                                        {{ Auth::user()->vendor->description }}
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6 col-md-6 text-start">
                                            <div class="mb-2"><i class="ti-truck"></i> Usually ships in <font class="font-medium">{{ Auth::user()->vendor->average_delivery_time() }} days</font></div>
                                            <i class="ti-location-pin"></i> {{ Auth::user()->vendor->city }}
                                        </div>
                                        <div class="col-6 col-md-6 text-end">
                                            <div class="mb-2"><a href="javascript:void(0)" class="link" data-bs-toggle="modal" data-bs-target="#share-modal">Share <i class="icon-share"></i></a></div>
                                            <div class="mb-2"><a href="javascript:void(0)" class="link" wire:click.prevent="copyLink">Copy link <i class="icon-paper-clip"></i></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="#" class="btn @if($listing_type == 'sale') btn-primary @else btn-secondary @endif" wire:click.prevent="changeListingTypeFilter('sale')">For Sale</a>
                    <a href="#" class="btn @if($listing_type == 'wanted') btn-primary @else btn-secondary @endif" wire:click.prevent="changeListingTypeFilter('wanted')">Wanted</a>
                    <a href="#" class="btn @if($sold) btn-primary @else btn-secondary @endif" wire:click.prevent="toggleSoldFilter">Sold</a>
                </div>
            </div>
            <div class="row mt-4">
            @foreach($products AS $product)
            <div class="col-6 col-md-2">
                <div class="card img-container">
                    @if($product->images->count() > 0)
                    <div class="w-100 amoury-img-cont">
                        <img class="my-amoury-product-image img-fluid" src="{{ asset('storage/'.$product->images->first()->image_url) }}" alt="Card image cap">
                    </div>
                    @endif
                    <div class="card-body produc-details ps-0">
                        <div class="p-0 m-0">
                            <h3 class="p-0 m-0">R{{ number_format($product->item_price, 2) }}</h3>
                        </div>
                        <p class="m-b-0 mt-0" style="text-transform: uppercase;">{{ $product->item_name }}</p>
                    </div>
                    <div class="overlay-icons">
                        <a href="{{ url('list-item/'.$product->id) }}"><i class=" icon-pencil"></i></a>
                        <a href="{{ url('shop/product/'.$product->id) }}">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="share-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 d-grid">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $share_link }}" target="_blank" class="btn btn-primary" style="background-color: #1877F2; padding: 14px 30px;">Share on Facebook</a>
                            </div>
                            <div class="mb-3 d-grid">
                                <a href="https://twitter.com/share?url={{ $share_link }}" target="_blank" class="btn btn-primary" style="background-color: #1DA1F2; padding: 14px 30px;">Share on X</a>
                            </div>
                            <div class="mb-3 d-grid">
                                <a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url={{ $share_link }}&title=&summary=" target="_blank" class="btn btn-primary" style="background-color: #0077B5; padding: 14px 30px;">Share on LinkedIn</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('copy-link', (event) => {
                var link = event.link;
                navigator.clipboard.writeText(link);

                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Link has been copied.',
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        })
        function showShareOptions(){
            var link = '{{ $link }}';
            console.log(link);
            Swal.fire({
                position: 'top-end',
                html:
                    '<b>Share</b> <br />' +
                    '<a href="https://www.facebook.com/sharer/sharer.php?u='+link+'" target="_blank">Share on Facebook</a><br />'+
                    '<a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url='+link+'&title=&summary=" target="_blank">Share on LinkedIn</a><br />'+
                    '<a href="https://twitter.com/share?url='+link+'" target="_blank">Share on x</a>',
            })
        }
    </script>
    @endpush
</div>