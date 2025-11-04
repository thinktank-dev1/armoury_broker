<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12 d-flex">
            <div class="">
                <h2>PRODUCTS</h2>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="@if($sub_sub_cats) col-md-4 @else col-md-6 @endif"></div>
                        <div class="@if($sub_sub_cats) col-md-8 @else col-md-6 @endif">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="search-addon"><i class="icon-magnifier"></i></span>
                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon" wire:model.live="search_key">
                                <select class="form-control" name="category_search" wire:model.live="category_search">
                                    <option value="">Search By Category</option>
                                    @foreach($cats AS $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                                @if($sub_cats)
                                <select class="form-control" name="sub_category_search" wire:model.live="sub_category_search">
                                    <option value="">Search By Sub Category</option>
                                    @foreach($sub_cats AS $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->sub_category_name }}</option>
                                    @endforeach
                                </select>
                                @endif
                                @if($sub_sub_cats)
                                <select class="form-control" name="sub_sub_cats_search" wire:model.live="sub_sub_cats_search">
                                    <option value="">Search By Sub Sub Categories</option>
                                    @foreach($sub_sub_cats AS $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->sub_category_name }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Featured</th>
                                <th>Vendor</th>
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
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:key="{{ $product->id.now() }}" value="" @if($product->featured) checked @endif wire:click.prevent="setFeatured({{ $product->id }})">
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('admin/vendors/'.$product->vendor->id) }}">{{ $product->vendor->name }}</a>
                                </td>
                                <td>{{ $product->item_name }}</td>
                                <td>{{ $product->brand->brand_name }}</td>
                                <td>{{ $product->category->category_name }} - @if($product->subCategory) {{ $product->subCategory->sub_category_name }} @endif @if($product->sub_sub) - {{ $product->sub_sub->sub_category_name }} @endif</td>
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