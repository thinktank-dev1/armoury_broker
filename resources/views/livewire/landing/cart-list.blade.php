<div>
    <div class="section py-5" wire:ignore.self> 
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    @if($errors->any())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        @foreach($cart_items_model AS $k=>$item_group)
                        @php
                            $f_item = $item_group->first();
                        @endphp
                        <div class="col-md-12 mb-3 d-none d-md-block">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <a href="{{ url('/'.$f_item->vendor->url_name) }}">
                                            <h4 class="card-title text-bold">{{ ucwords($f_item->vendor->name) }}</h4>
                                        </a>
                                        <div class="ms-auto">
                                            {{--
                                            <a href="{{ url('cart/'.$f_item->vendor->id) }}" class="btn btn-primary-outline">Checkout</a>
                                            --}}
                                            <a href="#" class="btn btn-primary-outline btn-checkout" wire:click.prevent="gotToCheckOut({{$f_item->vendor->id}})">Checkout</a>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="mt-3">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-end">Price</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item_group AS $item)
                                                @php
                                                $stk = $item->product->hasStock();
                                                if(!$stk){
                                                    $class = "text-no-stock";
                                                }
                                                else{
                                                    $class = "";
                                                }
                                                @endphp
                                                <tr class="{{ $class }}">
                                                    <td style="min-width: 50px;">
                                                        @if($item->product->images->count() > 0)
                                                            <img src="{{ asset('storage/'.$item->product->images->first()->image_url) }}" style="height: 25px;">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!$stk)
                                                            <span class="pr_flash2  bg-warning ">Sold</span>
                                                        @endif
                                                        <a href="{{ url('shop/product/'.$item->product->id) }}">
                                                            {{ ucwords($item->product->item_name) }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $item->product->item_description }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-end">R{{ number_format($item->price,2) }}</td>
                                                    <td class="text-end"><a href="#" wire:click.prevent="removeItem({{ $item->id }})"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-2">
                                      <small><b><i>Buying more than one item from this seller? Message them to combine items into one parcel and save on courier costs.</i></b> <a href="#" wire:click.prevent="showMessageModal({{ $f_item->vendor->id }})"><b>Message Seller</b></a></small> 
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
                                        {{--
                                        <a href="{{ url('cart/'.$f_item->vendor->id) }}" class="btn btn-primary-outline btn-sm">Checkout</a>
                                        --}}
                                        <a href="#" class="btn btn-primary-outline btn-sm btn-checkout" wire:click.prevent="gotToCheckOut({{$f_item->vendor->id}})">Checkout</a>
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
    </div>

    <div class="modal fade" tabindex="-1" id="message-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                @if($vendor)
                <div class="modal-header bg-blue">
                    <h5 class="modal-title text-white">Contact {{ $vendor->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveMessage">
                        @if($errors->any())
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            @if(Auth::guest())
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" wire:model.defer="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Surname</label>
                                    <input type="text" class="form-control" name="surname" wire:model.defer="surname">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" wire:model.defer="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" name="contact_number" wire:model.defer="contact_number">
                                </div>
                            </div>
                            @endif
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" wire:model.defer="message"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveMessage">Save changes</button>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-message-modal', () => {
                $('#message-modal').modal('show');
            })
            @this.on('message-sent', () => {
                $('.modal').modal('hide');
                $.notify("Message has been sent", "success");
            });
            @this.on('copy-link', (event) => {
                var link = event.link;
                navigator.clipboard.writeText(link);
                $.notify("Link has been copied", "success");
            });
        });
    </script>
    @endpush
</div>
