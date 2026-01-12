<div>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3 class="page-title bold">
                    @if(url()->current() != URL::previous())
                    <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                    @endif
                    MY VAULT
                </h3>
            </div>
        </div>
        <div class="row align-items-stretch">
            <div class="col-md-12">
                <div class="row align-items-stretch">
                    <div class="col-md-3 pb-0 mb-2">
                        <div class="card bordered bg-dark h-100 pb-0 mb-2">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="text-white bold">Vault Balance</h5>
                                    <div class="ms-auto">
                                        <span class="mytooltip tooltip-effect-1">
                                            <span class="tooltip-item text-white"><i class=" icon-info"></i></span> 
                                            <span class="tooltip-content clearfix">
                                                <span class="tooltip-text px-2">
                                                    <b>Available for shopping</b>
                                                    <p class="text-white">Total of all funds across all catagories</p>
                                                </span> 
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <h2 class="text-white bold">R {{ number_format($tot_credit,2) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pb-0 mb-2">
                        <div class="card bordered h-100 pb-0 mb-2">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="bold">Armoury Broker Credit</h5>
                                    <div class="ms-auto">
                                        <span class="mytooltip tooltip-effect-1">
                                            <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                            <span class="tooltip-content clearfix">
                                                <span class="tooltip-text px-2">
                                                    <b>Armoury Broker Credit</b>
                                                    <p class="text-white">Platfrom credits for covering fees only (Not cashable)</p>
                                                </span> 
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <h2 class="bold">R {{ number_format($ab_credit,2) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pb-0 mb-2">
                        <div class="card bordered h-100 pb-0 mb-2">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="bold text-muted">Gift Voucher Credit</h5>
                                    <div class="ms-auto">
                                        <span class="mytooltip tooltip-effect-1">
                                            <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                            <span class="tooltip-content clearfix">
                                                <span class="tooltip-text px-2">
                                                    <b>Gift Voucher Credit</b>
                                                    <p class="text-white">Unspent gift voucher credit (Expires in 12 months - Not cashable)</p>
                                                </span> 
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <h2 class="bold text-muted">Coming Soon</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pb-0 mb-2">
                        <div class="card bordered bg-dark h-100 pb-0 mb-2">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="text-white bold">Total Purchases</h5>
                                    <div class="ms-auto">
                                        <span class="mytooltip tooltip-effect-1">
                                            <span class="tooltip-item text-white"><i class=" icon-info"></i></span> 
                                            <span class="tooltip-content clearfix">
                                                <span class="tooltip-text px-2">
                                                    <b>Total Purchases</b>
                                                    <p class="text-white">Moneies spent on in platform purchases</p>
                                                </span> 
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <h2 class="text-white bold">R {{ number_format($tot_purchases,2) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pb-0 mb-2">
                        <div class="card bordered bg-dark h-100 pb-0 mb-2">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="text-white bold">Withdrawable Funds</h5>
                                    <div class="ms-auto">
                                        <span class="mytooltip tooltip-effect-1">
                                            <span class="tooltip-item text-white"><i class=" icon-info"></i></span> 
                                            <span class="tooltip-content clearfix">
                                                <span class="tooltip-text px-2">
                                                    <b>Withdrawable Funds</b>
                                                    <p class="text-white">You completed transaction earnings.(Can spend in the platfrom or cashout via EFT)</p>
                                                </span> 
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <h2 class="text-white bold">R {{ number_format($withdrawable_balance,2) }}</h2>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#withdrawal-modal" class="text-white"><u>Request Withdrawal</u></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pb-0 mb-2">
                        <div class="card bordered h-100 pb-0 mb-2">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="bold">Pending Withdrawal</h5>
                                    <div class="ms-auto">
                                        <span class="mytooltip tooltip-effect-1">
                                            <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                            <span class="tooltip-content clearfix">
                                                <span class="tooltip-text px-2">
                                                    <b>pending Withdrawal</b>
                                                </span> 
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <h2 class="bold">R {{ number_format($pending_withdrawal,2) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pb-0 mb-2">
                        <div class="card bordered h-100 pb-0 mb-2">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="bold">Orders In Progress</h5>
                                    <div class="ms-auto">
                                        <span class="mytooltip tooltip-effect-1">
                                            <span class="tooltip-item"><i class=" icon-info"></i></span> 
                                            <span class="tooltip-content clearfix">
                                                <span class="tooltip-text px-2">
                                                    <b>Orders In Progress</b>
                                                    <p class="text-white">Money held in Escrow until orders are completed</p>
                                                </span> 
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <h2 class="bold">R {{ $in_progress_orders,2 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pb-0 mb-2">
                        <div class="card bordered bg-dark h-100 pb-0 mb-2">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h5 class="text-white bold">Total Sales</h5>
                                    <div class="ms-auto">
                                        <span class="mytooltip tooltip-effect-1">
                                            <span class="tooltip-item text-white"><i class=" icon-info"></i></span> 
                                            <span class="tooltip-content clearfix">
                                                <span class="tooltip-text px-2">
                                                    <b>Total Sales</b>
                                                    <p class="text-white">Monies generated from in platfrom sales</p>
                                                </span> 
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <h2 class="text-white bold">R {{ number_format($tot_sales,2) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="#" class="btn @if($filter == 'all_transactions') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('all_transactions')">All Transactions</a>
                <a href="#" class="btn @if($filter == 'orders') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('orders')">Orders</a>
                <a href="#" class="btn @if($filter == 'purchases') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('purchases')">Purchases</a>
                <a href="#" class="btn @if($filter == 'refunds') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('refunds')">Refunds</a>
                <a href="#" class="btn @if($filter == 'complete') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('complete')">Complete</a>
                <a href="#" class="btn @if($filter == 'pending') btn-primary @else btn-secondary @endif" wire:click.prevent="changeFilter('pending')">Pending</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title">Transaction History</h5>
                            <div class="ms-auto">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">From</span>
                                    <input type="date" class="form-control form-control-sm" placeholder="Start Date" name="date_from" wire:model.live="date_from">
                                    <span class="input-group-text" id="basic-addon1">To</span>
                                    <input type="date" class="form-control form-control-sm" placeholder="End Date" name="date_to" wire:model.live="date_to">
                                    <a href="#" class="btn btn-sm btn-secondary px-3" wire:click.prevent="exportData('pdf')"><i class="fas fa-file-pdf"></i> Export PDF</a>
                                    <a href="#" class="btn btn-sm btn-secondary px-3" wire:click.prevent="exportData('csv')"><i class="far fa-file-excel"></i> Export CSV</a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Reference</th>
                                        <th>Vendor</th>
                                        <th>Status</th>
                                        <th class="text-end">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trxs AS $trx)
                                    <tr>
                                        <td>{{ date('Y-m-d', strtotime($trx->created_at)) }}</td>
                                        <td>{{ ucwords(str_replace('_', ' ',$trx->transaction_type)) }}</td>
                                        <td>
                                            @if($trx->order)
                                            {{ $trx->order->g_payment_id }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($trx->vendor)
                                                {{ $trx->vendor->name }}
                                            @endif
                                        </td>
                                        <td>{{ $trx->payment_status }}</td>
                                        <td class="text-end">
                                            @if($trx->direction == "out" || $trx->vendor_id != Auth::user()->vendor_id)
                                            -
                                            @endif
                                            R {{ number_format($trx->amount,2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--
        <div class="row mt-3">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row p-t-10 p-b-10">
                            <div class="col p-r-0">
                                <h3 class="font-light">{{ $items_sold }}</h3>
                                <h6 class="text-muted">Items Sold</h6>
                            </div>
                            <div class="col text-end align-self-center">
                                <div class="">
                                    <div class="round align-self-center round-primary">
                                        <i class="icon-basket-loaded"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row p-t-10 p-b-10">
                            <div class="col p-r-0">
                                <h3 class="font-light">R{{ number_format($tot_sales,2) }}</h3>
                                <h6 class="text-muted">Total Sales</h6>
                            </div>
                            <div class="col text-end align-self-center">
                                <div class="">
                                    <div class="round align-self-center round-primary">
                                        R
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row p-t-10 p-b-10">
                            <div class="col p-r-0">
                                <h3 class="font-light">R {{ number_format($tot_withdrawals, 2) }}</h3>
                                <h6 class="text-muted">Withdrawals</h6>
                            </div>
                            <div class="col text-end align-self-center">
                                <div class="">
                                    <div class="round align-self-center round-primary">
                                        <i class="ti-control-eject"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-dark">
                    <div class="card-body">
                        <div class="row p-t-10 p-b-10">
                            <div class="col p-r-0">
                                <h3 class="font-light text-white">R {{ number_format(Auth::user()->vendor->balance(), 2) }}</h3>
                                <h6 class="text-white">Balance</h6>
                            </div>
                            <div class="col text-end align-self-center">
                                <div class="">
                                    <div class="round align-self-center round-white">
                                        <i class="icon-wallet"></i>
                                    </div>
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
                    <div class="card-header d-flex">
                        <h4 class="card-title mt-2">Transactions</h4>
                        <span class="ms-auto">
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#withdrawal-modal">Request Withdrawal</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @if (session('message'))
                        <div class="row mt-3 mb-3">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    {{ session('message') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>DIR</th>
                                            <th>User</th>
                                            <th>Reff</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trxs AS $trx)
                                        <tr>
                                            <td>{{ date('d M Y', strtotime($trx->created_at)) }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ',$trx->transaction_type)) }}</td>
                                            <td>{{ ucwords($trx->direction) }}</td>
                                            <td>
                                                @if($trx->user)
                                                {{ $trx->user->name.' '.$trx->user->surname }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($trx->order)
                                                {{ $trx->order->g_payment_id }}
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                R {{ number_format($trx->amount) }}
                                            </td>
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
        --}}
    </div>
    <div class="modal fade" tabindex="-1" id="withdrawal-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Withdrawal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (session('status'))
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form wire:submit.prevent="requestWithdrawal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R</span>
                                        <input type="number" class="form-control" name="amount" wire:model.defer="amount">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr />
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" wire:model.defer="bank_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" name="branch_name" wire:model.defer="branch_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Branch Code</label>
                                    <input type="text" class="form-control" name="branch_code" wire:model.defer="branch_code">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Account Name</label>
                                    <input type="text" class="form-control" name="account_name" wire:model.defer="account_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" name="account_number" wire:model.defer="account_number">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="requestWithdrawal">Request withdrawal</button>
                </div>
            </div>
        </div>
    </div>
</div>