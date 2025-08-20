<footer class="footer_dark">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="widget">
                        <div class="footer_logo">
                            <a href="#"><img src="{{ asset('img/footer_logo.png') }}" alt="logo"/></a>
                        </div>
                        <div class="text-center footer-right-p mt-2">
                            <p>The trading platform built specifically for South Africa's firearm and tactical equipment community.</p>
                        </div>
                        <div class="mt-3 d-flex justify-content-around">
                            <a href="#"><img src="{{ asset('img/fb.png') }}"></a>
                            <a href="#"><img src="{{ asset('img/ins.png') }}"></a>
                            <a href="#"><img src="{{ asset('img/wa.png') }}"></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="widget">
                        <h6 class="widget_title">Quick Links</h6>
                        <ul class="widget_links">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="#">Categories</a></li>
                            <li><a href="{{ url('support') }}">Support</a></li>
                            <li><a href="{{ url('how-it-works') }}">How Armory Broker Works</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="widget">
                        @if(Auth::guest())
                        <a href="{{ url('auth/login') }}"><h6 class="widget_title">Login</h6></a>
                        @endif
                        <a href="{{ url('cart') }}"><h6 class="widget_title">Cart</h6></a>
                        <a href="{{ url('wishlist') }}"><h6 class="widget_title">Wishlist</h6></a>
                        <div class="mt-3">
                            <livewire:landing.partials.search />
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widget">
                        <h6 class="widget_title">Disclaimer</h6>
                        <p class="footer-disclaimer">Armoury Broker is a peer-to-peer marketplace platform. All transactions must comply with the <b>Firearms Control Act 60 of 2000</b>. We are not a licensed firearms dealer and do not handle firearms and regulated items directly. Users are solely responsible for legal compliance, licensing requirements, and all aspects of their transactions. Armoury Broker accepts no liability for user conduct, or legal compliance. Always consult licensed dealers and legal professionals regarding firearm transfers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p>Copyright &copy; {{ date('Y') }} ARMOURY BROKER. All Rights Reserved. | Designed and developed by <a href="https://thinktank.co.za" target="_blank">Thinktank Creative</a></p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="#">Terms & Conditions</a> |
                    <a href="#">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>