<div class="container-fluid">
    <link href="{{ asset('account/assets/node_modules/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('account/assets/node_modules/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('account/assets/node_modules/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <div class="row mt-3">
        <div class="col-md-12">
            <h3 class="page-title bold">
                @if(url()->current() != URL::previous())
                <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                @endif
                DASHBOARD
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Armoury</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <center class="profile-pic m-t-30">
                                <div class="d-flex justify-content-center">
                                    @if(Auth::user()->vendor)
                                        @if(Auth::user()->vendor->avatar)
                                            <img src="{{ asset('storage/'.Auth::user()->vendor->avatar) }}" class="circle-dash-avatar" />
                                        @else
                                            <img src="{{ asset('img/avatar_placeholder_large.png') }}" class="circle-dash-avatar" />
                                        @endif
                                    @else
                                        <img src="{{ asset('img/avatar_placeholder_large.png') }}" class="circle-dash-avatar" />
                                    @endif
                                    <span class="edit-btn">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#avatar-edit-modal"><i class="icon-pencil"></i></a>
                                    </span>
                                </div> 
                            </center>
                        </div>
                        <div class="col-md-8 ps-3 pt-4">
                            @if(Auth::user()->vendor)
                            <h3 class="bold">{{ Auth::user()->vendor->name }}</h3>
                            <div class="d-flex d-sm-flex justify-content-around justify-content-md-start">
                                <div>
                                    <b>{{ Auth::user()->vendor->likes->count() }}</b> Likes
                                </div>
                                <div class="ms-md-5">
                                    <b>{{ Auth::user()->vendor->sold() }}</b> Items Sold
                                </div>
                            </div>
                            <div class="text-start mt-3">
                                <div class="mb-2"><a href="javascript:void(0)" class="link"><i class="ti-truck"></i> Usually ships in <font class="font-medium">0 days</font></a></div>
                                <a href="javascript:void(0)" class="link"><i class="ti-location-pin"></i> {{ Auth::user()->vendor->city }}</a>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    @if(Auth::user()->dealer)
                                    <small>Registered Armoury Broker Dealer</small>
                                    @endif
                                </div>
                                <div class="col-md-6 text-small">
                                    <div class="text-end">
                                        <a href="javascript:void(0)" class="link" data-bs-toggle="modal" data-bs-target="#share-modal">
                                            <span class="">
                                                <i class="icon-share order-1 order-md-1 me-md-2 pt-md-1"></i>
                                                <span class="order-2 order-md-2">
                                                    Share 
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="text-end">
                                        <a href="javascript:void(0)" class="link" wire:click.prevent="copyLink">
                                            <span class="">
                                                <i class="icon-paper-clip order-1 order-md-1 me-md-2 pt-md-1"></i>
                                                <span class="order-2 order-md-2">
                                                    Copy 
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ url('profile') }}" class="link">
                                            <span class="">
                                                <i class="icon-pencil order-1 order-md-1 me-md-2 pt-md-1"></i>
                                                <span class="order-2 order-md-2">
                                                    Edit 
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row mt-3">
                                <div class="col-md-6 offset-md-2">
                                    <div class="ribbon">Coming<br>soon</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3>{{ Auth::user()->name.' '.Auth::user()->surname }}</h3>
                            <div class="mb-2">
                            Dealer Status: <b>@if(Auth::user()->dealer) Active @else Inactive @endif</b>
                            </div>
                            <div><i class=" icon-envelope"></i> {{ Auth::user()->email }}</div>
                            <div><i class=" icon-phone"></i> {{ Auth::user()->mobile_number }}</div>
                            <div><i class=" icon-social-instagram"></i> {{ Auth::user()->vendor->instagram_handle }}</div>
                            <div class="mt-2">
                                <p class="text-muted m-l-5">
                                    {{ Auth::user()->vendor->suburb }}<br />
                                    {{ Auth::user()->vendor->city }}<br />
                                    {{ Auth::user()->vendor->province }}<br />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Vault</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="ms-auto">
                            <span class="mytooltip tooltip-effect-1">
                                <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                <span class="tooltip-content tooltip-content-end tooltip-content-top clearfix">
                                    <span class="tooltip-text px-2">
                                        <b>My vault info</b>
                                        <p class="text-white">Fund Types:</p>
                                        <ul>
                                            <li><b>Available for shopping</b> - Money you can spend right now (withdrawable funds + gift voucher credit)</li>
                                            <li><b>Armoury broker credit</b> - Platform credits for covering fees only (promotional credits, not cashable)</li>
                                            <li><b>Gift voucher credit</b> - Unspent gift card balance (expires in 12 months, spend-only)</li>
                                            <li><b>Withdrawable funds</b> - Your completed transaction earnings (can spend or cash out via EFT)</li>
                                            <li><b>Orders in progress</b> - Money held in escrow until orders are confirmed received</li>
                                            <li><b>Total balance</b> - Complete overview of all your funds across all categories</li>
                                        </ul>
                                    </span> 
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h3 class="mb-0" style="line-height: 10px;">R {{ number_format($spendable_amount , 2) }}</h3>
                            <small>Available for shopping</small>
                        </div>
                    </div>
                    <div>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>R {{ number_format($ab_credit, 2) }}</td>
                                <td>Armoury Broker Credit</td>
                            </tr>
                            <tr>
                                <td>R {{ number_format($gift_voucher_balance, 2) }}</td>
                                <td>Gift Voucher Credit</td>
                            </tr>
                            <tr>
                                <td>R {{ number_format($withdrawable_balance, 2) }}</td>
                                <td>Withdrawable Funds</td>
                            </tr>
                            <tr>
                                <td>R {{ number_format($orders_in_progress, 2) }}</td>
                                <td>Orders In Progress</td>
                            </tr>
                            <tr>
                                <td class="bold">R {{ number_format($tot_credit, 2) }}</td>
                                <td class="bold">Total Balance</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Orders - This Month</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="ms-auto">
                            <span class="mytooltip tooltip-effect-1">
                                <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                <span class="tooltip-content clearfix">
                                    <span class="tooltip-text px-2">
                                        <b>My Orders</b>
                                        <p class="text-white">Data from last 30 days</p>
                                        <ul>
                                            <li><b>New:</b> Recently placed orders awaiting processing.</li>
                                            <li><b>In Progress:</b> Orders shipped, awaiting delivery/collection, or pending dealer stocking and awaiting buyer confirmation.</li>
                                            <li><b>Completed:</b> Fulfilled orders (completed or canceled).</li>
                                        </ul>
                                    </span> 
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="order-grid mt-2">
                        <a href="{{ url('my-orders') }}" class="order-box">
                            <div class="count">{{ $new_orders }}</div>
                            <div class="label">New</div>
                        </a>
                        <a href="{{ url('my-orders') }}" class="order-box">
                            <div class="count">{{ $in_progress_orders }}</div>
                            <div class="label">In Progress</div>
                        </a>
                        <a href="{{ url('my-orders') }}" class="order-box">
                            <div class="count">{{ $completed_orders }}</div>
                            <div class="label">Completed</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Purchases - This Month</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="ms-auto">
                            <span class="mytooltip tooltip-effect-1">
                                <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                <span class="tooltip-content clearfix">
                                    <span class="tooltip-text px-2">
                                        <b>My Purchases</b>
                                        <p class="text-white">Data from last 30 days</p>
                                        <ul>
                                            <li><b>In Progress:</b> Orders waiting for seller to fulfill and ship or currently in transit.</li>
                                            <li><b>Completed:</b> Purchases that have been received or cancelled.</li>
                                        </ul>
                                    </span> 
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2">
                            <div class="order-grid mt-2">
                                <a href="{{ url('my-purchases') }}" class="order-box">
                                    <div class="count">{{ $new_purchases }}</div>
                                    <div class="label">New</div>
                                </a>
                                <a href="{{ url('my-purchases') }}" class="order-box">
                                    <div class="count">{{ $completed_purcahses }}</div>
                                    <div class="label">Completed</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="ms-auto">
                            <span class="mytooltip tooltip-effect-1">
                                <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                <span class="tooltip-content tooltip-content-end clearfix">
                                    <span class="tooltip-text px-2">
                                        <b>My Actions</b>
                                        <ul>
                                            <li><b>New offers:</b> Offers you have made and/or received that need confirmation, counter, or decline.</li>
                                            <li><b>Active orders:</b> Combination of new and in-progress orders requiring your action, including shipping, arranging delivery/collection or dealer stocking.</li>
                                            <li><b>Purchases to confirm:</b> Shipped items waiting for your delivery confirmation to release payment.</li>
                                        </ul>
                                    </span> 
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="order-grid mt-2">
                        <a href="{{ url('messages') }}" class="order-box">
                            <div class="count">{{ $new_offers }}</div>
                            <div class="label">New Offers</div>
                        </a>
                        <a href="" class="order-box">
                            <div class="count">{{ $active_orders }}</div>
                            <div class="label">Active Orders</div>
                        </a>
                        <a href="" class="order-box">
                            <div class="count">{{ $purchases_to_confirm }}</div>
                            <div class="label">Purchases To Confirm</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Listings</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="ms-auto">
                            <span class="mytooltip tooltip-effect-1">
                                <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                <span class="tooltip-content clearfix">
                                    <span class="tooltip-text px-2">
                                        <b>My Listings</b>
                                        <ul>
                                            <li><b>Active:</b> Items currently listed and available in your Armoury.</li>
                                            <li><b>Sold:</b> Total number of items you've sold.</li>
                                            <li><b>Add new item:</b> Quick link to list a new item for sale.</li>
                                        </ul>
                                    </span> 
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="order-grid mt-2">
                        <a href="{{ url('my-armoury') }}" class="order-box">
                            <div class="count">{{ $listing_count }}</div>
                            <div class="label">Active</div>
                        </a>
                        <a href="" class="order-box">
                            <div class="count">{{ $sold_listings }}</div>
                            <div class="label">Sold</div>
                        </a>
                        <a href="#" class="order-box bg-dark-blue">
                            <div class="count text-white">+</div>
                            <div class="label text-white">Add New Item</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Order Analytics</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="ms-auto">
                            <span class="mytooltip tooltip-effect-1">
                                <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                <span class="tooltip-content tooltip-content-end clearfix">
                                    <span class="tooltip-text px-2">
                                        <b>Order Analytics</b>
                                        <p class="text-white">Monthly overview chart showing your sales performance over the past year:</p>
                                        <ul>
                                            <li><b>Left axis:</b> Number of orders sold</li>
                                            <li><b>Right axis:</b> Total value in ZAR</li>
                                            <li><b>Bottom axis:</b> Monthly timeline</li>
                                        </ul>
                                    </span> 
                                </span>
                            </span>
                        </div>
                    </div>
                    <canvas id="orderChart" height="45"></canvas>
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

    @push('scripts')
    <script src="{{ asset('account/assets/node_modules/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('account/assets/node_modules/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal', (event) => {
                $('.modal').modal('hide');
            });
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
        });
        $(document).ready(function(){
            const ctx = document.getElementById('orderChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Orders',
                        data: [8, 6, 5, 9, 7, 10, 67, 89, 34, 23, 15, 34],
                        backgroundColor: '#293c47',
                        yAxisID: 'y',
                        barThickness: 20,
                    },
                    {
                        label: 'Order Value',
                        data: [5000, 5500, 7000, 8500, 6500, 10000, 10000, 10000, 10000, 10000, 10000, 10000],
                        borderColor: '#ff7043',
                        borderWidth: 2,
                        type: 'line',
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    stacked: false,
                    scales: {
                        y: {
                            type: 'linear',
                            position: 'left',
                            title: { display: true, text: 'No. of Orders' }
                        },
                        y1: {
                            type: 'linear',
                            position: 'right',
                            title: { display: true, text: 'Order Value (R)' },
                            grid: { drawOnChartArea: false }
                        }
                    }
                }
            });
            /*
            lg_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            sm_labels = ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'];
            
            if(window.innerWidth < 768) {
                us_labels = sm_labels;
            }
            else{
                us_labels = lg_labels;
            }

            var data = {
                labels: us_labels,
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
            */
        })

        function showShareOptions(){
            var link = '{{ $share_link }}';
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