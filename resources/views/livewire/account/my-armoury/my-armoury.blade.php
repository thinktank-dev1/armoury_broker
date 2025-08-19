<div class="container-fluid">
    @if(Auth::user()->vendor)
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <center class="m-t-30">
                                @if(Auth::user()->vendor->avatar) 
                                <img src="{{ asset('storage/'.Auth::user()->vendor->avatar) }}" class="img-circle img-fluid">
                                @else
                                <img src="{{ asset('img/logo-placeholder.webp') }}" class="img-circle img-fluid">
                                @endif
                            </center>
                        </div>
                        <div class="col-md-10">
                            <h4 class="card-title m-t-10">Hanna Gover</h4>
                            <h6 class="card-subtitle">Accoubts Manager Amix corp</h6>
                            <div>
                                <a href="javascript:void(0)" class="link me-5"><i class="icon-like"></i> <font class="font-medium">0</font> Likes</a>
                                <a href="javascript:void(0)" class="link"><i class="icon-grid"></i> <font class="font-medium">0</font> Items Sold</a>
                            </div>
                            <div class="mt-3">
                                {{ Auth::user()->vendor->description }}
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-2"><a href="javascript:void(0)" class="link"><i class="ti-truck"></i> Usually ships in <font class="font-medium">0 days</font></a></div>
                                    <a href="javascript:void(0)" class="link"><i class="ti-location-pin"></i> {{ Auth::user()->vendor->city }}</a>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <div class="mb-2"><a href="javascript:void(0)" class="link" onclick="showShareOptions()">Share <i class="icon-share"></i></a></div>
                                    <a href="javascript:void(0)" class="link" wire:click.prevent="copyLink">Copy link <i class="icon-paper-clip"></i></a>
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
        <div class="col-md-2">
            <div class="card">
                @if($product->images->count() > 0)
                <img class="card-img-top img-responsive" src="{{ asset('storage/'.$product->images->first()->image_url) }}" alt="Card image cap">
                @endif
                <div class="card-body produc-details">
                    <div class="">
                        <h3>R{{ number_format($product->item_price, 2) }}</h3>
                    </div>
                    <p class="m-b-0 m-t-10">{{ $product->item_name }}</p>
                </div>
            </div>
        </div>
        @endforeach
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