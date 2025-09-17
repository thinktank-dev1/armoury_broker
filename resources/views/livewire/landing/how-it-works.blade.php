<div>
    <div class="section how-it-works bg_grey pt-5 pb-4">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-12 text-center">
                    <h2 class="page-title">How Armoury Broker Works</h2>
                </div>
            </div>
            <div class="row">
                @foreach($data AS $k => $dt)
                @php
                $i = $loop->index;
                $img = $i + 1;
                @endphp
                <div class="col-12 col-md-5 mb-4 mb-md-3 h-100">
                    <div class="bloc h-100">
                        <div class="esarfa">
                            <span class="bloc-icon"><img src="{{ asset('img/hiw/ICON S'.$img.'.png') }}" style="width: 35px"></span>
                            <span class="bloc-num">{{ str_pad($k, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="bloc-content h-100">
                            <div>
                                {{ $dt['step'] }}
                                <h5 class="text-21 bold">{{ $dt['title'] }}</h5>
                            </div>
                            <hr />
                            <div>
                                {{ $dt['description'] }}
                            </div>
                        </div>
                    </div>
                </div>
                @if($i % 2 == 0)
                <div class="d-none d-md-flex col-md-2 text-center d-flex align-items-center justify-content-center">
                    <img src="{{ asset('img/hiw-arrow.png') }}">
                </div>
                @endif
                @if($i % 2 == 1 && $i != (count($data) - 1))
                <div class="d-none d-md-flex col-md-12 text-center d-flex align-items-center justify-content-center mb-3">
                    <img src="{{ asset('img/hiw-btm-arrow.png') }}">
                </div>
                @endif
                @if($i != (count($data) - 1))
                <div class="col-12 d-md-none text-center mb-5">
                    <img src="{{ asset('img/hiw-arrow-down.png') }}">
                </div>
                @endif

                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Refer to our <b><a href="{{ url('docs/Terms of Use and User Agreement_AB_Courier amendments_v02_20250629.pdf') }}" target="_blank">Terms of Use</a></b> for more information</p>
                </div>
            </div>
        </div>
    </div>
    <div class="section section-services">
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{ asset('img/icon1.png') }}">
                    <div class="mt-2">
                        <p><b>Secure escrow protection</b></p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <img src="{{ asset('img/icon2.png') }}">
                    <div class="mt-2">
                        <p><b>Reminders</b></p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <img src="{{ asset('img/icon3.png') }}">
                    <div class="mt-2">
                        <p><b>Automatic notifications</b></p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <img src="{{ asset('img/icon4.png') }}">
                    <div class="mt-2">
                        <p><b>Full audit trail</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
