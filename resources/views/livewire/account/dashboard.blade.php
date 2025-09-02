<div class="container-fluid">
    <link href="{{ asset('account/assets/node_modules/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('account/assets/node_modules/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('account/assets/node_modules/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <div class="row mt-3">
        <div class="col-md-12">
            <h3 class="page-title bold">ACCOUNT SUMMARY</h3>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 col-md-4 align-self-center">
                            <div class="">
                                <div class="round align-self-center round-primary">
                                    <i class="icon-basket"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col p-l-0">
                            <h5 class="text-muted m-b-0 bold text-black">Orders</h5>
                            <h3 class="m-b-0 bold">{{ $orders }}</h3>
                            <div class="mt-2">
                                <a href="{{ url('my-orders') }}" class="text-black"><u>View Details</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 col-md-4 align-self-center">
                            <div class="">
                                <div class="round align-self-center round-primary">
                                    <i class="icon-list"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col p-l-0">
                            <h5 class="text-muted m-b-0 bold text-black">Listed Items</h5>
                            <h3 class="m-b-0 bold">{{ $listed }}</h3>
                            <div class="mt-2">
                                <a href="{{ url('my-armoury') }}" class="text-black"><u>View Details</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 col-md-4 align-self-center">
                            <div class="">
                                <div class="round align-self-center round-primary">
                                    <i class="icon-basket-loaded"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col p-l-0">
                            <h5 class="text-muted m-b-0 bold text-black">Purchases</h5>
                            <h3 class="m-b-0 bold">{{ $purchases }}</h3>
                            <div class="mt-2">
                                <a href="{{ url('my-purchases') }}" class="text-black"><u>View Details</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-dark-blue">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 col-md-4 align-self-center">
                            <div class="">
                                <div class="round align-self-center round-white">
                                    <i class="icon-wallet"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col p-l-0">
                            <h5 class="text-muted m-b-0 bold text-white">Wallet Total</h5>
                            @if(Auth::user()->vendor)
                            <h3 class="m-b-0 bold text-white">{{ number_format(Auth::user()->vendor->balance() , 2) }}</h3>
                            @else
                                <h3 class="m-b-0 bold text-white">0.00</h3>
                            @endif
                            <div class="mt-2">
                                <a href="{{ url('my-vault') }}" class="text-white"><u>View Details</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3" wire:ignore>
        <div class="col-md-6 h-100" wire:ignore>
            <div class="card h-100" wire:ignore>
                <div class="card-body h-100" wire:ignore>
                    <h4 class="card-title">Order Analytics</h4>
                    <div class="ct-bar-chart" style="height: 200px;" wire:ignore></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Profile Summary</h4>
                    <div class="row mt-3">
                        <div class="col-md-3 d-flex text-center justify-content-md-center">
                            @php
                            $img = "img/no-image.webp";
                            if(Auth::user()->vendor){
                                if(Auth::user()->vendor->avatar){
                                    $img = 'storage/'.Auth::user()->vendor->avatar;
                                }
                            }
                            @endphp
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset($img) }}" class="circle" />
                            </div>
                        </div>
                        <div class="text-center text-md-start col-md-9 ps-md-5">
                            <h3>{{ Auth::user()->name.' '.Auth::user()->surname }}</h3>
                            @if(Auth::user()->vendor)
                            <div class="d-flex d-sm-flex justify-content-around justify-content-md-start">
                                <div>
                                    <b>{{ Auth::user()->vendor->likes->count() }}</b> Likes
                                </div>
                                <div class="ms-md-5">
                                    <b>{{ Auth::user()->vendor->sold() }}</b> Items Sold
                                </div>
                            </div>
                            <div class="">
                                <p>{{ Auth::user()->vendor->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(Auth::user()->vendor)
                    <div class="row">
                        <div class="col-md-12 d-flex d-sm-flex justify-content-between mt-3">
                            <div class="mb-2">
                                <a href="javascript:void(0)" class="link" onclick="showShareOptions()">Share <i class="icon-share"></i></a>
                            </div>
                            <div class="mb-2">
                                <a href="javascript:void(0)" class="link" wire:click.prevent="copyLink">Copy link <i class="icon-paper-clip"></i></a>
                            </div>
                            <div class="mb-2">
                                <a href="{{ url('messages') }}" class="link">Messages <i class="icon-envelope"></i></a>
                            </div>
                            <div class="mb-2">
                                <a href="{{ url('my-armoury') }}" class="link"><u>View Profile</u></a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Orders Summary</h4>
                    <div class="row d-md-none">
                        <div class="col-md-12">
                            @foreach($order_items AS $item)
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Name:</span>
                                    <div class="ms-auto">
                                        <a href="{{ url('/'.$item->product->vendor->url_name) }}">
                                            {{ $item->user->name.' '.$item->user->surname }}
                                        </a>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Item:</span>
                                    <div class="ms-auto">
                                        {{ ucwords($item->product->item_name) }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Date:</span>
                                    <div class="ms-auto">
                                        {{ date('d M Y', strtotime($item->created_at)) }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Status:</span>
                                    <div class="ms-auto">
                                        @if($item->order)
                                            {{ $item->order->status }}
                                        @endif
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Total Price:</span>
                                    <div class="ms-auto">
                                        R {{ number_format($item->price,2) }}
                                    </div>
                                </li>
                            </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="row d-none d-md-block">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Item</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order_items AS $item)
                                    <tr>
                                        <td>
                                            @if($item->user->vendor)
                                            <a href="{{ url('/'.$item->user->vendor->url_name) }}">
                                            {{ $item->user->name.' '.$item->user->surname }}
                                            </a>
                                            @else
                                            {{ $item->user->name.' '.$item->user->surname }}
                                            @endif
                                        </td>
                                        <td>{{ ucwords($item->product->item_name) }}</td>
                                        <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @if($item->order)
                                            {{ $item->order->status }}
                                            @endif
                                        </td>
                                        <td>R {{ number_format($item->price,2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-end">
                                <a href="{{ url('my-orders') }}" class="btn btn-primary">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Purchase Summary</h4>
                    <div class="row d-md-none">
                        <div class="col-md-12">
                            @foreach($purcahse_items AS $item)
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Name:</span>
                                    <div class="ms-auto">
                                        <a href="{{ url('/'.$item->user->vendor->url_name) }}">
                                            {{ $item->user->name.' '.$item->user->surname }}
                                        </a>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Item:</span>
                                    <div class="ms-auto">
                                        {{ ucwords($item->product->item_name) }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Date:</span>
                                    <div class="ms-auto">
                                        {{ date('d M Y', strtotime($item->created_at)) }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Status:</span>
                                    <div class="ms-auto">
                                        @if($item->order)
                                            {{ $item->order->status }}
                                        @endif
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Total Price:</span>
                                    <div class="ms-auto">
                                        R {{ number_format($item->price,2) }}
                                    </div>
                                </li>
                            </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="row d-none d-md-block">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Item</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purcahse_items AS $item)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/'.$item->user->vendor->url_name) }}">
                                            {{ $item->user->name.' '.$item->user->surname }}
                                            </a>
                                        </td>
                                        <td>{{ ucwords($item->product->item_name) }}</td>
                                        <td>{{ date('d M Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @if($item->order)
                                            {{ $item->order->status }}
                                            @endif
                                        </td>
                                        <td>R {{ number_format($item->price,2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-end">
                                <a href="{{ url('my-purchases') }}" class="btn btn-primary">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('account/assets/node_modules/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('account/assets/node_modules/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
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
        $(document).ready(function(){
            var data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                series: [
                    [5, 4, 3, 7, 5, 10, 3, 4, 8, 10, 6, 8]
            ]};
            var options = {
                seriesBarDistance: 10
            };
            var responsiveOptions = [
                ['screen and (max-width: 640px)', {
                    seriesBarDistance: 5,
                    axisX: {
                        labelInterpolationFnc: function (value) {
                            return value[0];
                        }
                    }
                }]
            ];
            new Chartist.Bar('.ct-bar-chart', data, {
                plugins: [
                    Chartist.plugins.tooltip()
                ]
            }, options, responsiveOptions);
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