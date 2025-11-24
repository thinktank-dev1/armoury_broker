<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/FAVICON.png') }}">
        <title>Armoury Broker</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <link href="{{ asset('account/assets/node_modules/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('account/assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">

         <link href="{{ asset('account/dist/css/pages/stylish-tooltip.css') }}" rel="stylesheet">

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
        </div>

        <div class="modal fade" tabindex="-1" id="logout-warning">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="text-lg font-semibold mb-2">Session Expiring Soon</h2>
                        <p>You will be logged out in <span id="countdown">30</span> seconds due to inactivity.</p>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                        <button type="button" class="btn btn-primary" onclick="stayLoggedIn()">Stay logged in</button>
                    </div>
                </div>
            </div>
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
        <script src="{{ asset('account/assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
        @stack('scripts')

        @if(!Auth::guest())
            @include('components.layouts.session')
        @endif

    </body>
</html>