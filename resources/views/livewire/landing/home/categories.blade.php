<div class="section pb_50 small_pt mt-3" id="categories">
    @if($categories->count() > 0)
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
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
        <div class="row d-none" id="other-cats">
            @foreach($other_cats AS $cat)
            <div class="col-md-3">
                <div class="sale_banner">
                    <a class="hover_effect1" href="{{ url('shop?category='.$cat->slug) }}">
                        @if($cat->category_image)
                        <img src="{{ asset('storage/'.$cat->category_image) }}" alt="shop_banner_img3">
                        @else
                        <img src="{{ asset('img/CATEGORIES - PLACEHOLDER.png') }}" alt="shop_banner_img3">
                        @endif
                        <div class="cat-text text-21"><h3>{{ $cat->category_name }}</h3></div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="co-md-12 text-center">
                <a href="#categories" class="btn btn-primary-outline" id="cat-btn" onclick="showOtherCats()">View All</a>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        function showOtherCats(){
            var elem = $('#other-cats');
            if(elem.hasClass('d-none')){
                $(elem).removeClass('d-none');
                $(elem).addClass('d-flex');
                $('#cat-btn').text('View Less');
            }
            else{
                $(elem).removeClass('d-flex');
                $(elem).addClass('d-none');
                $('#cat-btn').text('View All');
            }
        }
    </script>
    @endpush
</div>