<footer class="footer_dark">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mt-4 mt-md-0">
                    <div class="widget text-center">
                        <div class="footer_logo text-center">
                            <a href="#"><img src="{{ asset('img/footer_logo.png') }}" alt="logo"/></a>
                        </div>
                        <div class="text-center footer-right-p mt-2">
                            <p>The trading platform built specifically for South Africa's firearm and tactical equipment community.</p>
                        </div>
                        {{--
                        <div class="mt-3 d-flex justify-content-around">
                            <a href="#"><img src="{{ asset('img/fb.png') }}"></a>
                            <a href="#"><img src="{{ asset('img/ins.png') }}"></a>
                            <a href="#"><img src="{{ asset('img/wa.png') }}"></a>
                        </div>
                        --}}
                        <div class="mt-3 mx-3 d-flex justify-content-around">
                            <a href="https://www.facebook.com/share/1b3FRqbnJS/?mibextid=wwXIfr" target="_blank" class="btn btn-sqr" style="padding: .375rem 1.099rem;"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/armourybroker?igsh=MTU2amNjd2FlZzNqdw%3D%3D&utm_source=qr" target="_blank" class="btn btn-sqr"><i class=" fab fa-instagram"></i></a>
                            <a href="https://whatsapp.com/channel/0029VbAeBVdGU3BG6pu2kS3C" target="_blank" class="btn btn-sqr"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mt-4 mt-md-0">
                    <div class="widget text-center text-md-start">
                        <h6 class="widget_title">Quick Links</h6>
                        <ul class="widget_links">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/#categories') }}">Categories</a></li>
                            <li><a href="{{ url('support') }}">Support</a></li>
                            <li><a href="{{ url('how-it-works') }}">How Armoury Broker Works</a></li>
                            <li><a href="{{ url('docs/Terms of Use and User Agreement_AB_Courier amendments_v02_20250629.pdf') }}" target="_blank">Terms of Use</a></li>
                            <li><a href="{{ url('docs/Privacy Policy V1.0_20250702.pdf') }}" target="_blank">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 mt-4 mt-md-0">
                    <div class="widget text-center text-md-start">
                        @if(Auth::guest())
                        <a href="{{ url('auth/login') }}"><h6 class="widget_title">Register / Login</h6></a>
                        @endif
                        <a href="{{ url('cart') }}"><h6 class="widget_title">Cart</h6></a>
                        @if(!Auth::guest())
                        <a href="{{ url('wishlist') }}"><h6 class="widget_title">Wishlist</h6></a>
                        @endif
                        <div class="mt-3">
                            <livewire:landing.partials.search />
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="widget text-center text-md-start">
                        <h6 class="widget_title">Disclaimer</h6>
                        <p class="footer-disclaimer">Armoury Broker is a peer-to-peer marketplace platform. All transactions must comply with the <b><a href="https://www.gov.za/documents/firearms-control-act" target="_blank">Firearms Control Act 60 of 2000</a></b>. We are not a licensed firearms dealer and do not handle firearms and regulated items directly. Users are solely responsible for legal compliance, licensing requirements, and all aspects of their transactions. Armoury Broker accepts no liability for user conduct, or legal compliance. Always consult licensed dealers and legal professionals regarding firearm transfers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom pt-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 text-center text-md-start">
                    <p>&copy; 2025 ARMOURY BROKER, (PTY) LTD. | All Rights Reserved | Developed by <a href="https://thinktank.co.za" target="_blank">Thinktank Creative</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>