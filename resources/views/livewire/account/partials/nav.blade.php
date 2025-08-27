<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @if(Auth::user()->role->name == "user")
                <li>
                    <div class="mx-3">
                        <button onclick="window.location.href='{{ url("add-product") }}'" class="btn btn-white"><span class="hide-menu">Add Item</span> +</button>
                    </div>
                </li>
                @endif
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('/') }}" aria-expanded="false">
                        <i class="icon-home"></i>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>
                @if(Auth::user()->role->name == "admin")
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('admin/withdrawals') }}" aria-expanded="false">
                        <i class="ti-control-eject"></i>
                        <span class="hide-menu">Withdrawals</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('admin/brands') }}" aria-expanded="false">
                        <i class="icon-globe"></i>
                        <span class="hide-menu">Brands</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('admin/categories') }}" aria-expanded="false">
                        <i class="icon-list"></i>
                        <span class="hide-menu">Categories</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('admin/dealers') }}" aria-expanded="false">
                        <i class="icon-people"></i>
                        <span class="hide-menu">Dealers</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('admin/vendors') }}" aria-expanded="false">
                        <i class="icon-people"></i>
                        <span class="hide-menu">Vendors</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('admin/products') }}" aria-expanded="false">
                        <i class="icon-list"></i>
                        <span class="hide-menu">Products</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('admin/users') }}" aria-expanded="false">
                        <i class="icon-list"></i>
                        <span class="hide-menu">Users</span>
                    </a>
                </li>
                @else
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('dashboard') }}" aria-expanded="false">
                        <i class="icon-speedometer"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('my-armoury') }}" aria-expanded="false">
                        <i class="icons-Army-Key"></i>
                        <span class="hide-menu">My Armoury</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('my-orders') }}" aria-expanded="false">
                        <i class="icon-basket"></i>
                        <span class="hide-menu">My Orders</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('my-purchases') }}" aria-expanded="false">
                        <i class="icon-basket-loaded"></i>
                        <span class="hide-menu">My Purchases</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('my-vault') }}" aria-expanded="false">
                        <i class="ti-widget"></i>
                        <span class="hide-menu">My Vault</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('my-promo-codes') }}" aria-expanded="false">
                        <i class="ti-ticket"></i>
                        <span class="hide-menu">Promo Codes</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('messages') }}" aria-expanded="false">
                        <i class="ti-email"></i>
                        <span class="hide-menu">Messages</span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('profile') }}" aria-expanded="false">
                        <i class="ti-settings"></i>
                        <span class="hide-menu">Settings</span>
                    </a>
                </li>
                @endif
                <li>
                    <a class="waves-effect waves-dark" href="{{ url('auth/logout') }}" aria-expanded="false">
                        <i class="icon-logout"></i>
                        <span class="hide-menu">Log Out</span>
                    </a>
                </li>
            </ul>
            <div class="mt-5 mx-3">
                <a href="{{ url('support') }}" class="btn btn-primary-outline">Support</a>
            </div>
            <div class="mt-3 text-center">
                <a class="text-white" href="{{ url('support') }}">FAQ</a><br />
                <a class="text-white" href="{{ url('how-it-works') }}">How Armoury Broker Works</a>
            </div>
            <div class="mt-3 mx-3 d-flex justify-content-around">
                <a href="#" class="btn btn-sqr"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="btn btn-sqr"><i class=" fab fa-instagram"></i></a>
                <a href="#" class="btn btn-sqr"><i class="fab fa-whatsapp"></i></a>
            </div>
        </nav>
    </div>
</aside>