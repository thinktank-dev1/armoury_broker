<div>
    <div class="section py-5" wire:ignore.self> 
        <div class="container">
            <div class="row">
                @foreach($cart_items_model AS $k=>$item_group)
                @php
                    $f_item = $item_group->first();
                @endphp
                <div class="col-md-12 mb-3 d-none d-md-block">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <h4 class="card-title text-bold">{{ ucwords($f_item->vendor->name) }}</h4>
                                <div class="ms-auto">
                                    <a href="{{ url('cart/'.$f_item->vendor->id) }}" class="btn btn-primary-outline">Checkout</a>
                                </div>
                            </div>
                            <hr />
                            <div class="mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item_group AS $item)
                                        <tr>
                                            <td>{{ ucwords($item->product->item_name) }}</td>
                                            <td>{{ $item->product->item_description }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">R{{ number_format($item->price,2) }}</td>
                                            <td class="text-end"><a href="#" wire:click.prevent="removeItem({{ $item->id }})"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-md-12 d-md-none">
                    @foreach($cart_items_model AS $k=>$item_group)
                    <ul class="list-group">
                        <li class="list-group-item active d-flex align-items-center" aria-current="true">
                            <h3>{{ ucwords($f_item->vendor->name) }}</h3>
                            <div class="ms-auto">
                                <a href="{{ url('cart/'.$f_item->vendor->id) }}" class="btn btn-primary-outline btn-sm">Checkout</a>
                            </div>
                        </li>
                        @foreach($item_group AS $item)
                        <li class="list-group-item d-flex">
                            <span>{{ ucwords($item->product->item_name) }}</span>
                            <div class="ms-auto text-end">
                                R{{ number_format($item->price,2) }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endforeach
                </div>

                @foreach($cart_items_session AS $key=>$item_group)
                <div class="col-md-12 mb-3 d-none d-md-block">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <h4 class="card-title">{{ ucwords($item_group[0]['product']->vendor->name) }}</h4>
                                <div class="ms-auto">
                                    <a href="{{ url('cart/'.$item_group[0]['product']->vendor->id) }}" class="btn btn-primary-outline">Checkout</a>
                                </div>
                            </div>
                            <hr />
                            <div class="mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item_group AS $k => $item)
                                        <tr>
                                            <td>{{ ucwords($item['product']->item_name) }}</td>
                                            <td>{{ $item['product']->item_description }}</td>
                                            <td class="text-center">{{ $item['cart_item']['quantity'] }}</td>
                                            <td class="text-end">R{{ number_format($item['cart_item']['price'],2) }}</td>
                                            <td class="text-end"><a href="#" wire:click.prevent="removeSessionItem({{ $item['cart_item']['product_id'] }})"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-md-12 d-md-none">
                    @foreach($cart_items_session AS $key=>$item_group)
                    <ul class="list-group">
                        <li class="list-group-item active d-flex align-items-center" aria-current="true">
                            <h3>{{ ucwords($item_group[0]['product']->vendor->name) }}</h3>
                            <div class="ms-auto">
                                <a href="{{ url('cart/'.$item_group[0]['product']->vendor->id) }}" class="btn btn-primary-outline btn-sm">Checkout</a>
                            </div>
                        </li>
                        @foreach($item_group AS $k => $item)
                        <li class="list-group-item d-flex">
                            <span>{{ ucwords($item['product']->item_name) }}</span>
                            <div class="ms-auto text-end">
                                R{{ number_format($item['cart_item']['price'],2) }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endforeach
                </div>

                @php
                $md = null;
                if(is_array($cart_items_model)){
                    if(count($cart_items_model) > 0){
                        $md = true;
                    }
                }
                if ($cart_items_model instanceof \Illuminate\Database\Eloquent\Collection) {
                    if($cart_items_model->count() > 0){
                        $md = true;
                    }
                }
                @endphp
                @if(!$md && !$cart_items_session)
                <div class="row">
                    <div class="col-md-12 text-center mt-5 mb-3">
                        <h1 class="text-muted">Your shopping cart is empty</h1>
                    </div>
                    <div class="col-md-12 mb-5 text-center">
                        <a href="{{ url('shop') }}" class="btn btn-secondary">Continue Shopping</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
