<div class="section pb_50 small_pt bg-grey" id="brands">
    @if($brands->count() > 0)
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-3">
                <h2 class="page-title">Shop by brands</h2>
            </div>
        </div>
        <div class="row">
            @foreach($brands AS $brand)
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ url('shop?brands='.$brand->slug) }}" class="hover_effect1">
                    <img src="{{ asset('storage/'.$brand->brand_logo) }}" class="img-fluid">
                </a>
            </div>
            @endforeach
        </div>
        <div class="row d-none" id="other-brands">
            @foreach($other_brands AS $brand)
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ url('shop?brands='.$brand->slug) }}" class="hover_effect1" style="position: relative;">
                    @if($brand->brand_logo)
                    <img src="{{ asset('storage/'.$brand->brand_logo) }}" class="img-fluid bodered">
                    @else
                    <div class="brand-container">
                        <h3 class="text-dark text">{{ $brand->brand_name }}</h3>
                        <img src="{{ asset('img/LOGO - PLACEHOLDER.png') }}" class="img-fluid" alt="shop_banner_img3">
                    </div>
                    @endif
                </a>
            </div>
            @endforeach
        </div>
        <div class="row mt-3 mb-4">
            <div class="col-md-12 text-center">
                {{--
                <a href="#brands" class="btn btn-secondary" id="brand-btn" onclick="showOtherBrands()">View All</a>
                --}}
                <a href="{{ url('shop') }}" class="btn btn-secondary" id="brand-btn">View All</a>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        function showOtherBrands(){
            var elem = $('#other-brands');
            if(elem.hasClass('d-none')){
                $(elem).removeClass('d-none');
                $(elem).addClass('d-flex');
                $('#brand-btn').text('View Less');
            }
            else{
                $(elem).removeClass('d-flex');
                $(elem).addClass('d-none');
                $('#brand-btn').text('View All');
            }
        }
    </script>
    @endpush
</div>