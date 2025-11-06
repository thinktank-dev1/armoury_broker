<div class="section pb_50 small_pt mb-0 pb-0 pt-2">
    @if($products->count() > 0)
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="text-center">
                    <h2 class="page-title">Recently Added</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row product_list">
                    @foreach($products AS $product)
                    <livewire:landing.shop.partials.product-list-item :id="$product->id" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>