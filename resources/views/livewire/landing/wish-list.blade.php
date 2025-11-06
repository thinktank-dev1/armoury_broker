<div>
    <div class="section head support-bg" wire:ignore.self>
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
    <div class="section py-5" wire:ignore.self>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row product_list">
                        @foreach($lists AS $list)
                        @php
                        $product = $list->product;
                        @endphp
                        <livewire:landing.shop.partials.product-list-item :id="$product->id" />
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
</div>