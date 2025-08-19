<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12 d-flex">
            <h2>AB DEALER NETWORK</h2>
            <span class="ms-auto">
                <a href="#" class="btn btn-secondary">Export Dealers</a>
                <a href="{{ url('admin/dealers/create') }}" class="btn btn-primary">Add Dealer</a>
            </span>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>License Number</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dealers AS $dealer)
                            <tr>
                                <td>{{ $dealer->business_name }}</td>
                                <td>{{ $dealer->license_number }}</td>
                                <td>{{ $dealer->business_city.' '.$dealer->business_province }}</td>
                                <td>
                                    @if($dealer->status == 0)
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($dealer->status == 1)
                                    <span class="badge bg-success">Active</span>
                                    @elseif($dealer->status == 2)
                                    <span class="badge bg-danger">Disabled</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ url('admin/dealers/view/'.$dealer->id) }}"><i class="icon-eye"></i> View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $dealers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>