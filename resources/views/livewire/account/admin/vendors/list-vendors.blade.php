<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12 d-flex">
            <div class="">
                <h2>VENDORS</h2>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="search-addon"><i class="icon-magnifier"></i></span>
                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon" wire:model.live="search_key">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>User</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Products</th>
                                        <th>Location</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendors AS $vnd)
                                    <tr>
                                        <td>{{ $vnd->name }}</td>
                                        <td>{{ $vnd->user->name.' '.$vnd->user->surname }}</td>
                                        <td>{{ $vnd->tel }}</td>
                                        <td>{{ $vnd->email }}</td>
                                        <td>{{ $vnd->products->count() }}</td>
                                        <td>{{ $vnd->city }}</td>
                                        <td class="text-end">
                                            <a href="{{ url('admin/vendors/'.$vnd->id) }}"><i class="icon-folder-alt"></i> View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $vendors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>