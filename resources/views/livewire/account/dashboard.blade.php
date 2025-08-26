<div class="container-fluid">
    <link href="{{ asset('account/assets/node_modules/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('account/assets/node_modules/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('account/assets/node_modules/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>ACCOUNT SUMMERR</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card bg-grey">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="align-self-center">
                            <img src="{{ asset('img/ORDERS ICON.png') }}">
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h5 class="text-muted m-b-0 bold text-black">Orders</h5>
                            <h3 class="m-b-0 bold">{{ $orders }}</h3>
                            <div class="mt-2">
                                <a href="{{ url('my-orders') }}" class="text-black">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-grey">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="align-self-center">
                            <img src="{{ asset('img/LISTED ICON.png') }}">
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h5 class="text-muted m-b-0 bold text-black">Listed Items</h5>
                            <h3 class="m-b-0 bold">{{ $listed }}</h3>
                            <div class="mt-2">
                                <a href="{{ url('my-armoury') }}" class="text-black">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-grey">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="align-self-center">
                            <img src="{{ asset('img/PURCHASES ICON.png') }}">
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h5 class="text-muted m-b-0 bold text-black">Purchases</h5>
                            <h3 class="m-b-0 bold">{{ $purchases }}</h3>
                            <div class="mt-2">
                                <a href="{{ url('my-purchases') }}" class="text-black">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark-blue">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="align-self-center">
                            <img src="{{ asset('img/Wallet Icon.png') }}">
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h5 class="text-muted m-b-0 bold text-white">Wallet Total</h5>
                            <h3 class="m-b-0 bold text-white">{{ number_format(Auth::user()->vendor->balance() , 2) }}</h3>
                            <div class="mt-2">
                                <a href="{{ url('my-vault') }}" class="text-white"><u>View Details</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 h-100">
            <div class="card h-100 bg-grey">
                <div class="card-body h-100">
                    <h4 class="card-title">Order Analytics</h4>
                    <div class="ct-bar-chart" style="height: 200px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-grey">
                <div class="card-body">
                    <h4 class="card-title">Profile Summery</h4>
                    <div class="row">
                        <div class="col-md-3">
                            @php
                            $img = "img/no-image.webp";
                            if(Auth::user()->vendor->avatar){
                                $img = 'storage/'.Auth::user()->vendor->avatar;
                            }
                            @endphp
                            <div>
                                <img src="{{ asset($img) }}" class="circle" />
                            </div>
                        </div>
                        <div class="col-md-9 ps-5">
                            <h3>{{ Auth::user()->name.' '.Auth::user()->surname }}</h3>
                            <div class="d-flex">
                                <div>
                                    <b>{{ Auth::user()->vendor->likes->count() }}</b> Likes
                                </div>
                                <div class="ms-5">
                                    <b>{{ Auth::user()->vendor->sold() }}</b> Items Sold
                                </div>
                            </div>
                            <div class="">
                                <p>{{ Auth::user()->vendor->description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between mt-3">
                            <div class="mb-2">
                                <a href="javascript:void(0)" class="link" onclick="showShareOptions()">Share <i class="icon-share"></i></a>
                            </div>
                            <div class="mb-2">
                                <a href="javascript:void(0)" class="link" wire:click.prevent="copyLink">Copy link <i class="icon-paper-clip"></i></a>
                            </div>
                            <div class="mb-2">
                                <a href="javascript:void(0)" class="link">Messages <i class="icon-envelope-open"></i></a>
                            </div>
                            <div class="mb-2">
                                <a href="javascript:void(0)" class="link">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card bg-grey">
                <div class="card-body">
                    <h4 class="card-title">Orders Summery</h4>
                    <div class="row">
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
                                        <td>{{ $item->user->name.' '.$item->user->surname }}</td>
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
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card bg-grey">
                <div class="card-body">
                    <h4 class="card-title">Purchase Summery</h4>
                    <div class="row">
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
                                        <td>{{ $item->user->name.' '.$item->user->surname }}</td>
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
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('account/assets/node_modules/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('account/assets/node_modules/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script>
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
                new Chartist.Bar('.ct-bar-chart', data, options, responsiveOptions);
        })
    </script>
    @endpush
</div>