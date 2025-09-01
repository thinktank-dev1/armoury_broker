<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
        <title>Armoury Broker</title>
        <link href="{{ asset('account/assets/node_modules/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('account/dist/css/style.min.css') }}" rel="stylesheet">
        <link href="{{ asset('account/dist/css/custom.css') }}" rel="stylesheet">
    </head>
    <body class="skin-default-dark fixed-layout">
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Armoury Broker</p>
            </div>
        </div>
        <div id="main-wrapper">
            <livewire:account.partials.header />
            @include('livewire/account/partials/nav')
            <div class="page-wrapper">
                {{ $slot }}
            </div>
            <footer class="footer">
                <div class="row">
                    <div class="col-md-12">
                        Copyright © {{ date('Y') }} Armoury Broker. All rights reserved | Designed & Developed by
                        <a href="https://www.thinktank.co.za/" target="_blank">Thinktank Creative</a>    
                    </div>
                </div>
            </footer>
        </div>
        <script src="{{ asset('account/assets/node_modules/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('account/assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('account/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
        <script src="{{ asset('account/dist/js/waves.js') }}"></script>
        <script src="{{ asset('account/dist/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('account/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
        <script src="{{ asset('account/assets/node_modules/sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('account/dist/js/custom.js') }}"></script>
        <script src="{{ asset('account/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
        @stack('scripts')
    </body>
</html>