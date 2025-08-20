<div class="section pb_50 small_pt">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
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
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <a href="{{ url('dashboard') }}" class="btn dark-btn">Start Selling</a>
            </div>
        </div>
    </div>
</div>