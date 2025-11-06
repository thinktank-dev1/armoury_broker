<div>
    @if($products->count() > 0)
    <div class="section small_pt mt-3 mb-0 pb-0">
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
                    <div class="product_slider product_list carousel_slider owl-carousel owl-theme nav_style3 owl-loaded owl-drag" data-loop="true" data-dots="false" data-nav="true" data-margin="20" data-responsive="{&quot;0&quot;:{&quot;items&quot;: &quot;1&quot;}, &quot;767&quot;:{&quot;items&quot;: &quot;2&quot;}, &quot;991&quot;:{&quot;items&quot;: &quot;3&quot;}, &quot;1199&quot;:{&quot;items&quot;: &quot;6&quot;}}">
                        <div class="owl-stage-outer">
                            <div class="owl-stage" style="transform: translate3d(-1514px, 0px, 0px); transition: 0.25s; width: 4166px;">
                                @foreach($products AS $product)
                                    <livewire:landing.shop.partials.single-list-item wire:key="feat_{{ $product->id }}" :id="$product->id">
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
    </div>
    @endif
</div>