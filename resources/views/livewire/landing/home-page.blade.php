<div>
    <div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
        <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active background_bg" data-img-src="{{ asset('img/banner1.png') }}">
                    <div class="banner_slide_content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-6">
                                    <div class="banner_content overflow-hidden">
                                        <h5 class="mb-3 staggered-animation font-weight-light text-white" data-animation="slideInLeft" data-animation-delay="0.5s">SECURE | VERIFIED | RELIABLE</h5>
                                        <p class="staggered-animation text-white" data-animation="slideInLeft" data-animation-delay="1s">The trading platform built specifically<br /> for South Africa's firearm and tactical <br />equipment community.</p>
                                        <p class="staggered-animation text-white" data-animation="slideInLeft" data-animation-delay="1s">Ready to <b>LEVEL UP?</b></p>
                                        <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="{{ url('auth/login') }}" data-animation="slideInLeft" data-animation-delay="1.5s">Join Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item background_bg" data-img-src="{{ asset('img/banner2.png') }}">
                    <div class="banner_slide_content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="banner_content overflow-hidden">
                                        <h5 class="mb-3 staggered-animation font-weight-light text-white" data-animation="slideInLeft" data-animation-delay="0.5s">THREE STEPS TO SECURE TRADING</h5>
                                        <p class="staggered-animation text-white" data-animation="slideInLeft" data-animation-delay="1s">The trading platform</p>
                                        <ul class="staggered-animation text-white" data-animation="slideInLeft" data-animation-delay="1s">
                                            <li><b><i class="linearicons-arrow-right"></i> Upload your item</b></li>
                                            <li><b><i class="linearicons-arrow-right"></i> Ship to buyer</b></li>
                                            <li><b><i class="linearicons-arrow-right"></i> Get paid safely</b></li>
                                        </ul>
                                        <p class="staggered-animation text-white mt-3" data-animation="slideInLeft" data-animation-delay="1s">Our escrow system protects every transaction from start to finish.</p>
                                        <p class="staggered-animation text-white" data-animation="slideInLeft" data-animation-delay="1s">Ready to <b>LEVEL UP?</b></p>
                                        <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="{{ url('auth/login') }}" data-animation="slideInLeft" data-animation-delay="1.5s">Join Now</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- END CONTAINER-->
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev"><i class="ion-chevron-left"></i></a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next"><i class="ion-chevron-right"></i></a>
        </div>
    </div>
    <div class="main_content">
        <livewire:landing.home.categories />
        <livewire:landing.home.brands />
        <livewire:landing.home.featured />
        <livewire:landing.home.recently-added />
    </div>
</div>
