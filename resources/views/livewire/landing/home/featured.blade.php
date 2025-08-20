<div class="section pb_20 small_pt">
    @if($products->count() > 0)
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="heading_tab_header">
                    <div class="text-center">
                        <h2 class="page-title">Featured</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product_slider product_list carousel_slider owl-carousel owl-theme nav_style3 owl-loaded owl-drag" data-loop="true" data-dots="false" data-nav="true" data-margin="20" data-responsive="{&quot;0&quot;:{&quot;items&quot;: &quot;1&quot;}, &quot;767&quot;:{&quot;items&quot;: &quot;2&quot;}, &quot;991&quot;:{&quot;items&quot;: &quot;3&quot;}, &quot;1199&quot;:{&quot;items&quot;: &quot;4&quot;}}">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(-1514px, 0px, 0px); transition: 0.25s; width: 4166px;">
                            @foreach($products AS $product)
                            <div class="owl-item cloned" style="width: 258px; margin-right: 20px;">
                                <div class="item">
                                    <div class="product">
                                        <div class="product_img">
                                            <a href="{{ url('shop/product/'.$product->id) }}">
                                                @if($product->images->count() > 0)
                                                <img src="{{ asset('storage/'.$product->images->first()->image_url) }}" alt="product_img3">
                                                @else
                                                <img src="{{ asset('img/no-image.webp') }}">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product_info mt-2">
                                            <h6 class="product_title mb-1">
                                                R {{ number_format($product->item_price, 2) }}
                                            </h6>
                                            <div class="product-name">
                                                <a href="{{ url('shop/product/'.$product->id) }}">
                                                    {{ $product->item_name }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="owl-nav">
                        <button type="button" role="presentation" class="owl-prev">
                            <i class="ion-ios-arrow-left"></i>
                        </button>
                        <button type="button" role="presentation" class="owl-next">
                            <i class="ion-ios-arrow-right"></i>
                        </button>
                    </div>
                    <div class="owl-dots disabled"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>