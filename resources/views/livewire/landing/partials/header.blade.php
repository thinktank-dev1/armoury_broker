<header class="header_wrap fixed-top header_with_topbar">
    <div class="middle-header dark_skin header-top-section">
        <div class="container">
            <div class="nav_block">
                <div class="row d-flex align-items-center">
                    <div class="col-md-3 g-3">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img class="logo_light" src="{{ asset('img/logo.png') }}" alt="logo" />
                            <img class="logo_dark" src="{{ asset('img/logo.png') }}" alt="logo" />
                        </a>        
                    </div>
                    <div class="col-md-9 text-center ms-md-auto text-md-end g-4 d-none d-md-block">
                        @if(!Auth::guest())
                        <a class="ms-3 bold" href="{{ url('dashboard') }}">Dashboard</a>
                        <a class="ms-3 bold" href="{{ url('wishlist') }}">Wishlist</a>
                        @endif
                        <a class="ms-3 bold" href="{{ url('cart') }}">Cart @if($cart_count)<span class="cart_count">{{ $cart_count }}</span>@endif</a>
                        @if(Auth::guest())
                        <a class="ms-3 btn btn-primary-outline" href="{{ url('auth/login') }}">Register / Login</a>
                        @endif
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
                        <li><a class="nav-link nav_item bold" href="{{ url('/') }}">Home</a></li>
                        <li><a class="nav-link nav_item bold" href="{{ url('shop') }}">Shop</a></li>
                        <li class="dropdown dropdown-mega-menu">
                            <a class="dropdown-toggle nav-link bold" href="#" data-bs-toggle="dropdown">Categories</a>
                            <div class="d-md-none dropdown-menu">
                                <ul class="mega-menu d-lg-flex">
                                    <li class="mega-menu-col col-lg-9">
                                        <ul class="d-lg-flex">
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Shop By Category</li>
                                                    @foreach($categories AS $cat)
                                                    <li>
                                                        <a class="dropdown-item nav-link nav_item d-flex @if($cur_cat_id == $cat->id) active @endif" href="{{ url('shop?category='.$cat->slug) }}">
                                                            {{ $cat->category_name }}
                                                            <span class="ms-auto me-2"></span>
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="d-none d-md-block dropdown-menu">
                                <ul class="mega-menu d-lg-flex">
                                    <li class="mega-menu-col col-lg-12">
                                        <ul class="d-lg-flex">
                                            <li class="mega-menu-col {{ $menu_col }}">
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
                                            <li class="mega-menu-col {{ $menu_col }}" wire:key="{{ $cat->id.'-'.now() }}">
                                                <ul>
                                                    <li class="dropdown-header">Sub Categories</li>
                                                    @foreach($subs AS $sub)
                                                        @if($show_third_level_menu && $sub_row_count)
                                                            @if($loop->index == $sub_row_count)
                                                                </ul>
                                                                <li class="mega-menu-col {{ $menu_col }}">
                                                                <ul>
                                                                <li class="dropdown-header">&nbsp;</li>
                                                            @endif
                                                        @endif
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
                                </ul>
                            </div>
                        </li>
                        <li><a class="nav-link nav_item bold" href="{{ url('support') }}">Support</a></li>
                        @if(!Auth::guest())
                        <li class="d-md-none"><a class="nav-link nav_item bold" href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="d-md-none"><a class="nav-link nav_item bold" href="{{ url('wishlist') }}">Wishlist</a></li>
                        @endif
                        <li class="d-md-none"><a class="nav-link nav_item bold" href="{{ url('cart') }}">Cart</a></li>
                        <li class="d-md-none mb-5 text-center">
                            <a class="ms-3 btn btn-secondary btn-header-sm btn-nav" href="{{ url('auth/login') }}">Register / Login</a>
                        </li> 
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    @if(!Auth::guest())
                        @if($msg_count)
                            <li><a href="{{ url('messages') }}" class="nav-link"><i class="linearicons-envelope"></i><span class="cart_count">{{ $msg_count }}</span></a></li>
                        @endif
                    @endif
                    <li class="d-none d-md-block nav-search">
                        <livewire:landing.partials.search />
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>