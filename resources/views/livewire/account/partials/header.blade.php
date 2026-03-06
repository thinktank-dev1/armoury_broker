<header class="topbar">
    <style>
        @media (max-width: 767px) {
            .mini-sidebar .left-sidebar, .mini-sidebar .sidebar-footer {
                left: -242px;
            }
        }
        @media (max-width: 1023px) {
            .topbar, .topbar .top-navbar, .topbar .top-navbar .navbar-header, .topbar .top-navbar .navbar-collapse {
                background: #293c47 !important;
            }
            .topbar .top-navbar {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                justify-content: space-between !important;
            }
            .topbar .navbar-header {
                display: flex !important;
                align-items: center !important;
                width: 50% !important;
                background: #293c47 !important;
            }
            .topbar .navbar-collapse {
                display: flex !important;
                flex-basis: auto !important;
                background: #293c47 !important;
            }
            .topbar .navbar-nav {
                flex-direction: row !important;
            }
            .topbar .nav-link, .topbar .nav-link i, .topbar .navbar-brand {
                color: #ffffff !important;
            }
        }
    </style>
    <nav class="navbar top-navbar navbar-expand-lg navbar-dark py-2">
        <div class="navbar-header d-flex align-items-center">
            <a class="nav-link nav-toggler d-block d-lg-none waves-effect waves-dark px-3" href="javascript:void(0)"><i class="ti-menu" style="font-size: 24px; color: #ffffff !important;"></i></a>
            <a class="navbar-brand ms-2" href="{{ url('/') }}">
                <b class="">
                    <div class="d-none d-lg-block">
                        <img src="{{ asset('img/HEADER LOGO.png') }}" alt="homepage" class="dark-logo" style="width: 360px;" />
                        <img src="{{ asset('img/HEADER LOGO.png') }}" alt="homepage" class="light-logo" style="width: 360px;" />
                    </div>
                    <div class="d-lg-none">
                        <img src="{{ asset('img/logo-sm.png') }}" alt="homepage" class="light-logo" style="width: 50px; display: block !important;"/>    
                    </div>
                </b> 
            </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav me-auto">
                {{--
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                --}}
            </ul>
            <ul class="navbar-nav my-lg-0 flex-row">
                <li class="nav-item">
                    <a class="nav-link bold px-2" href="{{ url('profile') }}" id="2"><i class="ti-settings d-lg-none"></i><span class="d-none d-lg-inline">Profile</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link bold px-2" href="{{ url('wishlist') }}" id="2"><i class="ti-star d-lg-none"></i><span class="d-none d-lg-inline">Wishlist</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link bold px-2" href="{{ url('cart') }}" id="2"><i class="ti-shopping-cart d-lg-none"></i><span class="d-none d-lg-inline">Cart</span></a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link bold px-2" href="{{ url('messages') }}" id="2">
                        <i class="ti-email" style="font-size: 15px;"></i>
                        @if($msg_count)
                        <span class="msg_count">{{ $msg_count }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>