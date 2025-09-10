<div class="section pb_50 small_pt bg-grey">
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
                <a href="{{ url('shop?brands='.$brand->slug) }}" class="hover_effect1">
                    @if($brand->brand_logo)
                    <img src="{{ asset('storage/'.$brand->brand_logo) }}" class="img-fluid">
                    @else
                    <div class="brand-cont d-flex justify-content-center align-items-center">
                        <h3 class="text-dark">{{ $brand->brand_name }}</h3>
                    </div>
                    @endif
                </a>
            </div>
            @endforeach
        </div>
        <div class="row mt-3 mb-4">
            <div class="col-md-12 text-center">
                <a href="javascript:void(0)" class="btn btn-secondary" id="brand-btn" onclick="showOtherCats()">View All</a>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        function showOtherCats(){
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