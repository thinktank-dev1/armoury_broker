<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>Withdrawal Requests</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="card-title">Withdrawal Requests</h4>
                        <span class="ms-auto">
                            <a href="#" class="btn btn-primary btn-sm" wire:click.prevent="exportWithdrawals">Export</a>
                        </span>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>Bank</th>
                                        <th>Branch Name</th>
                                        <th>Branch Code</th>
                                        <th>Acc Name</th>
                                        <th>Acc No.</th>
                                        <th>Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests AS $req)
                                    <tr>
                                        <td>{{ $req->vendor->name }}</td>
                                        <td>{{ $req->bank_name }}</td>
                                        <td>{{ $req->branch_name }}</td>
                                        <td>{{ $req->branch_code }}</td>
                                        <td>{{ $req->account_name }}</td>
                                        <td>{{ $req->account_number }}</td>
                                        <td>R {{ number_format($req->amount,2) }}</td>
                                        <td class="text-end">
                                            <a href="#" wire:click.prevent="setPaid({{ $req->id }})">Paid</a>
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