<div>
    <div class="section head wishlist-bg" wire:ignore.self>
        <div class="head-back">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-title text-center">
                            <h3 class="text-white mt-3">MY WISHLIST</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="#" class="btn @if($cur_view == 'items') btn-secondary @else btn-primary-outline @endif" wire:click.prevent="changeView('items')">Liked Items</a>
                    <a href="#" class="btn @if($cur_view == 'stores') btn-secondary @else btn-primary-outline @endif" wire:click.prevent="changeView('stores')">Liked Stores</a>
                </div>
            </div>
        </div>
    </div>
    @if($cur_view == 'items')
    <div class="section py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row product_list">
                        @foreach($lists AS $list)
                        @php
                        $product = $list->product;
                        @endphp
                        @if($product->status == 1)
                        <livewire:landing.shop.partials.product-list-item wire:key="{{ $product->id }}" :id="$product->id" />
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @if($lists->count() == 0)
            <div class="row">
                    <div class="col-md-12 text-center mt-5 mb-3">
                        <h1 class="text-muted">Your wishlist is empty</h1>
                    </div>
                    <div class="col-md-12 mb-5 text-center">
                        <a href="{{ url('shop') }}" class="btn btn-secondary">Continue Shopping</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @elseif($cur_view == 'stores')
    <div class="section py-2 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row shops_list">
                        @foreach($liked_stores AS $liked_store)
                        <livewire:landing.shop.partials.liked-shops wire:key="{{ $liked_store->id }}" :id="$liked_store->id" />
                        @endforeach
                    </div>
                </div>
            </div>
            @if($liked_stores->count() == 0)
            <div class="row">
                    <div class="col-md-12 text-center mt-5 mb-3">
                        <h1 class="text-muted">Your liked stores is empty</h1>
                    </div>
                    <div class="col-md-12 mb-5 text-center">
                        <a href="{{ url('shop') }}" class="btn btn-secondary">Continue Shopping</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>