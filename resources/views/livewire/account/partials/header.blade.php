<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                <b class="">
                    <div class="d-none d-md-block">
                        <img src="{{ asset('img/HEADER LOGO.png') }}" alt="homepage" class="dark-logo" style="width: 360px;" />
                        <img src="{{ asset('img/HEADER LOGO.png') }}" alt="homepage" class="light-logo" style="width: 360px;" />
                    </div>
                    <div class="d-md-none">
                        <img src="{{ asset('img/logo-sm.png') }}" alt="homepage" class="dark-logo" style="width: 60px;" />
                        <img src="{{ asset('img/logo-sm.png') }}" alt="homepage" class="light-logo" style="width: 60px;"/>    
                    </div>
                </b> 
            </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav me-auto">
                {{--
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                --}}
            </ul>
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item">
                    <a class="nav-link bold" href="{{ url('profile') }}" id="2">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link bold" href="{{ url('wishlist') }}" id="2">Wishlist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link bold" href="{{ url('cart') }}" id="2">Cart</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link bold" href="{{ url('messages') }}" id="2">
                        <i class="ti-email" style="font-size: 15px;"></i>
                        @if($msg_count)
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        @endif
                    </a>
                </li>
                {{--
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('messages') }}" id="2"> 
                        Messages &nbsp;<i class="ti-email" style="font-size: 15px;"></i>
                        @if($msg_count)
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        @endif
                    </a>
                </li>
                <li class="nav-item right-side-toggle"> 
                    <a class="nav-link  waves-effect waves-light d-flex align-items-center h-100" href="{{ url('profile') }}">
                        Profile
                        @if(Auth::user()->vendor)
                            @if(Auth::user()->vendor->avatar)
                                &nbsp;<img src="{{ asset('storage/'.Auth::user()->vendor->avatar) }}" class="round_head img-fluid">
                            @else
                                <!-- &nbsp;<i class="ti-user" style="font-size: 15px;"></i> -->
                                &nbsp;<img src="{{ asset('img/PROFILE PIC.png') }}" class="round_head img-fluid">
                            @endif
                        @else
                            &nbsp;<img src="{{ asset('img/PROFILE PIC.png') }}" class="round_head img-fluid">
                        @endif
                    </a>
                </li>
                --}}
            </ul>
        </div>
    </nav>
</header>