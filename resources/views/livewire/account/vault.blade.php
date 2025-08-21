<div>
    <div class="container-fluid">
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
                                        <i class="ti-shopping-cart-full"></i>
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
                                        <i class="ti-money"></i>
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
                                <h3 class="font-light text-white">R {{ number_format($balance, 2) }}</h3>
                                <h6 class="text-white">Balance</h6>
                            </div>
                            <div class="col text-end align-self-center">
                                <div class="">
                                    <div class="round align-self-center round-white">
                                        <i class="ti-wallet"></i>
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
                        <h4 class="m-b-0">Transactions</h4>
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