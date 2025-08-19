<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12 d-flex">
            <div class="">
                <h2>VENDORS</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <center class="m-t-30">
                                @if($vendor->avatar) 
                                <img src="{{ asset('storage/'.$vendor->avatar) }}" class="img-circle" width="150">
                                @else
                                <img src="{{ asset('img/logo-placeholder.webp') }}" class="img-circle" width="150">
                                @endif
                                <h4 class="card-title m-t-10">{{ $vendor->name }}</h4>
                                <h6 class="card-subtitle">{{ $vendor->description }}</h6>
                            </center>
                        </div>
                    </div>
                </div>
                <div>
                    <hr> 
                </div>
                <div class="card-body"> 
                    <small class="text-muted">Vendor Name</small>
                    <h6>{{ $vendor->name }}</h6>

                    <small class="text-muted">Telephone</small>
                    <h6>{{ $vendor->tel }}</h6>

                    <small class="text-muted">Email</small>
                    <h6>{{ $vendor->email }}</h6>

                    <small class="text-muted">Address</small>
                    <h6>{{ $vendor->street.', '.$vendor->suburb.', '.$vendor->city }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class=card>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Model #</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products AS $product)
                            <tr>
                                <td>{{ ucwords($product->item_name) }}</td>
                                <td>{{ $product->brand->brand_name }}</td>
                                <td>{{ $product->category->category_name }} - {{ $product->subCategory->sub_category_name }} @if($product->sub_sub) - {{ $product->sub_sub->sub_category_name }} @endif</td>
                                <td>{{ $product->listing_type }}</td>
                                <td>{{ $product->model_number }}</td>
                                <td class="text-end">
                                    <a href="{{ url('admin/products/'.$product->id) }}"><i class="icon-folder-alt"></i> View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>