<div class="container-fluid">
    @if(Auth::user()->vendor)
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body px-5">
                    <div class="row">
                        <div class="col-md-2">
                            <center class="mt-3">
                                @if(Auth::user()->vendor->avatar) 
                                <img src="{{ asset('storage/'.Auth::user()->vendor->avatar) }}" class="circle img-fluid">
                                @else
                                <img src="{{ asset('img/logo-placeholder.webp') }}" class="img-circle img-fluid">
                                @endif
                            </center>
                        </div>
                        <div class="col-md-10 text-center text-md-start">
                            <h4 class="card-title m-t-10">{{ Auth::user()->vendor->name }} </h4>
                            <h6 class="card-subtitle mt-2">{{ url(Auth::user()->vendor->url_name) }}</h6>
                            <div>
                                <a href="javascript:void(0)" class="link me-5"><i class="icon-like"></i> <font class="font-medium">{{ Auth::user()->vendor->likes->count() }}</font> Likes</a>
                                <a href="javascript:void(0)" class="link"><i class="icon-grid"></i> <font class="font-medium">{{ $sold_count }}</font> Items Sold</a>
                            </div>
                            <div class="mt-3">
                                {{ Auth::user()->vendor->description }}
                            </div>
                            <div class="row mt-3">
                                <div class="col-6 col-md-6 text-start">
                                    <div class="mb-2"><a href="javascript:void(0)" class="link"><i class="ti-truck"></i> Usually ships in <font class="font-medium">0 days</font></a></div>
                                    <a href="javascript:void(0)" class="link"><i class="ti-location-pin"></i> {{ Auth::user()->vendor->city }}</a>
                                </div>
                                <div class="col-6 col-md-6 text-end">
                                    <div class="mb-2"><a href="javascript:void(0)" class="link" data-bs-toggle="modal" data-bs-target="#share-modal">Share <i class="icon-share"></i></a></div>
                                    <div class="mb-2"><a href="javascript:void(0)" class="link" wire:click.prevent="copyLink">Copy link <i class="icon-paper-clip"></i></a></div>
                                    <!-- <a href="{{ url('my-armoury/edit') }}" class="link">Edit <i class="icon-pencil"></i></a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        @foreach($products AS $product)
        <div class="col-6 col-md-2">
            <div class="card img-container">
                @if($product->images->count() > 0)
                <img style="border: 1px solid #CCC;" class="my-amoury-product-image img-fluid" src="{{ asset('storage/'.$product->images->first()->image_url) }}" alt="Card image cap">
                @endif
                <div class="card-body produc-details ps-0">
                    <div class="">
                        <h3>R{{ number_format($product->item_price, 2) }}</h3>
                    </div>
                    <p class="m-b-0 m-t-10" style="text-transform: uppercase;">{{ $product->item_name }}</p>
                </div>
                <div class="overlay-icons">
                    <a href="{{ url('add-product/'.$product->id) }}"><i class=" icon-pencil"></i></a>
                    <a href="{{ url('shop/product/'.$product->id) }}">View</a>
                </div>
            </div>
        </div>
        @endforeach
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