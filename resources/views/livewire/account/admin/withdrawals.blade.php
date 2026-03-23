<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h3 class="page-title bold">
                @if(url()->current() != URL::previous())
                <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                @endif
                Withdrawal Requests
            </h3>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="card-title">Withdrawal Requests</h4>
                        <span class="ms-auto">
                            <div class="input-group mb-3">
                                <select class="form-control" wire:model.live="status">
                                    <option value="0">Pending</option>
                                    <option value="1">Paid</option>
                                </select>
                                <button class="btn btn-primary" type="button" wire:click.prevent="exportWithdrawals">Export</button>
                            </div>
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
                                            @if($req->status == 0)
                                            <a href="#" class="btn btn-primary" wire:click.prevent="setPaid({{ $req->id }})">Paid</a>
                                            @endif
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