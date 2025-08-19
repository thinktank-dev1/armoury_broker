<div>
    <div class="section">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-md-12 text-center">
                    <h2 class="page-title">How Armoury Broker Works</h2>
                </div>
            </div>
            <div class="row">
                @foreach($data AS $k => $dt)
                <div class="col-md-6 mb-3">
                    <div class="bloc">
                        <div class="esarfa">
                            <span class="bloc-icon"><i class="{{ $dt['icon'] }}"></i></span>
                            <span class="bloc-num">{{ str_pad($k, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="bloc-content">
                            <div>
                                {{ $dt['step'] }}
                                <h5>{{ $dt['title'] }}</h5>
                            </div>
                            <hr />
                            <div>
                                {{ $dt['description'] }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Refer to our <b><a href="#">terms of use</a></b> for more information</p>
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
                        <p><b>24/7 Hour reminder</b></p>
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
