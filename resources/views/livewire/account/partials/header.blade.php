<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('dashboard') }}">
                <b class="">
                    <div class="d-none d-md-block">
                        <img src="{{ asset('img/logo.png') }}" alt="homepage" class="dark-logo" style="width: 160px;" />
                        <img src="{{ asset('img/logo-light.png') }}" alt="homepage" class="light-logo" style="width: 160px;" />
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
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('messages') }}" id="2"> 
                        Messages <i class="ti-email"></i>
                        @if($msg_count)
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        @endif
                    </a>
                </li>
                <li class="nav-item right-side-toggle"> 
                    <a class="nav-link  waves-effect waves-light d-flex align-items-center h-100" href="{{ url('profile') }}">
                        Profile
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/'.Auth::user()->avatar) }}" class="round_head img-fluid">
                        @else
                            <i class="ti-user"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>