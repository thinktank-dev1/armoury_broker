<div>
    <div class="section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="text-center">
                        <h2 class="page-title">My Wish-list</h2>
                    </div>
                </div>
            </div>
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
        </div>
    </div>
</div>