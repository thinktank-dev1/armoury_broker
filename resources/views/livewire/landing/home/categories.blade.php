<div class="section pb_20 small_pt">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h2 class="page-title">Categories</h2>
            </div>
        </div>
        <div class="row">
            @foreach($categories AS $cat)
            <div class="col-md-3">
                <div class="sale_banner">
                    <a class="hover_effect1" href="{{ url('shop?category='.$cat->slug) }}">
                        <img src="{{ asset('storage/'.$cat->category_image) }}" alt="shop_banner_img3">
                        <div class="cat-text text-21"><h3>{{ $cat->category_name }}</h3></div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-3 mb-3">
            <div class="co-md-12 text-center">
                <a href="{{ url('categories') }}" class="btn btn-primary-outline">View All</a>
            </div>
        </div>
    </div>
</div>