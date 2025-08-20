<div class="section pb_50 small_pt bg-grey">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h2 class="page-title">Shop by brands</h2>
            </div>
        </div>
        <div class="row">
            @foreach($brands AS $brand)
            <div class="col-md-2 mb-3">
                <a href="{{ url('shop?brands='.$brand->slug) }}">
                    <img src="{{ asset('storage/'.$brand->brand_logo) }}" class="img-fluid">
                </a>
            </div>
            @endforeach
        </div>
        <div class="row mt-3 mb-4">
            <div class="col-md-12 text-center">
                <a href="{{ url('brands') }}" class="bnt dark-btn">View All</a>
            </div>
        </div>
    </div>
</div>