<header class="header_wrap fixed-top header_with_topbar">
    <div class="middle-header dark_skin header-top-section">
        <div class="container">
            <div class="nav_block">
                <div class="row">
                    <div class="col-md-3 g-3">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img class="logo_light" src="{{ asset('img/logo.png') }}" alt="logo" />
                            <img class="logo_dark" src="{{ asset('img/logo.png') }}" alt="logo" />
                        </a>        
                    </div>
                    <div class="col-md-6 g-3 d-flex justify-content-center">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <livewire:landing.partials.search />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-end g-4">
                        @if(Auth::guest())
                        <a class="ms-3 bold" href="{{ url('auth/login') }}">Login</a>
                        @else
                        <a class="ms-3 bold" href="{{ url('dashboard') }}">Dashboard</a>
                        <a class="ms-3 bold" href="{{ url('wishlist') }}">Wishlist</a>
                        @endif
                        <a class="ms-3 bold" href="{{ url('cart') }}">Cart @if($cart_count)<span class="cart_count">{{ $cart_count }}</span>@endif</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg"> 
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false"> 
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-start" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li><a class="nav-link nav_item" href="{{ url('/') }}">Home</a></li>
                        <li class="dropdown dropdown-mega-menu">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Categories</a>
                            <div class="dropdown-menu">
                                <ul class="mega-menu d-lg-flex">
                                    <li class="mega-menu-col col-lg-9">
                                        <ul class="d-lg-flex">
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Shop By Category</li>
                                                    @foreach($categories AS $cat)
                                                    <li>
                                                        <a class="dropdown-item nav-link nav_item d-flex @if($cur_cat_id == $cat->id) active @endif" href="#" wire:click.prevent="getSubCats({{ $cat->id }})">
                                                            {{ $cat->category_name }}
                                                            <span class="ms-auto me-2"><i class="ion-chevron-right"></i></span>
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @if($subs)
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Sub Categories</li>
                                                    @foreach($subs AS $sub)
                                                    <li>
                                                        @if($sub->sub_sub->count() > 0)
                                                            <a class="dropdown-item nav-link nav_item d-flex" href="#" wire:click.prevent="getSubSub({{ $sub->id }})">
                                                        @else
                                                            <a class="dropdown-item nav-link nav_item d-flex" href="{{ url('shop?category='.$sub->category->slug.'&sub-category='.$sub->slug) }}">
                                                        @endif
                                                            {{ $sub->sub_category_name }}
                                                            @if($sub->sub_sub->count() > 0)
                                                            <span class="ms-auto me-2"><i class="ion-chevron-right"></i></span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endif
                                            @if($sub_subs)
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Sub Categories</li>
                                                    @foreach($sub_subs AS $sub)
                                                    <li><a class="dropdown-item nav-link nav_item" href="{{ url('shop?category='.$sub->category->slug.'&sub-category='.$sub->parent_sub->slug.'&sub-sub-category='.$sub->slug) }}">{{ $sub->sub_category_name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li class="mega-menu-col col-lg-3">
                                        <div class="header_banner">
                                            <div class="header_banner_content">
                                                <div class="shop_banner">
                                                    <div class="banner_img overlay_bg_40">
                                                        <img src="{{ asset('img/shop_banner.jpg') }}" alt="shop_banner"/>
                                                    </div> 
                                                    <div class="shop_bn_content">
                                                        <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                                        <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                                        <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a class="nav-link nav_item" href="{{ url('support') }}">Support</a></li> 
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    @if(!Auth::guest())
                    <li><a href="#" class="nav-link"><i class="linearicons-alarm"></i></a></li>
                    <li><a href="#" class="nav-link"><i class="linearicons-envelope"></i><span class="cart_count">2</span></a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header>