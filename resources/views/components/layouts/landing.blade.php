<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Armoury Broker</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">	
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet"> 

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


        <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/linearicons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">

        <link href="{{ asset('account/assets/node_modules/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/themify-icons@1.0.1/css/themify-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
        @stack('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom-responsive.css') }}">
    </head>
    <body>
        <livewire:landing.partials.header />
        {{ $slot }}
        <livewire:landing.partials.footer />
        <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a> 
        
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script> 
        <script src="{{ asset('assets/js/popper.min.js') }}"></script> 
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>  
        <script src="{{ asset('assets/owlcarousel/js/owl.carousel.min.js') }}"></script>  
        <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>  
        <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>  
        <script src="{{ asset('assets/js/parallax.js') }}"></script>  
        <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>  
        <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script> 
        <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.dd.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.elevatezoom.js') }}"></script> 
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
        <script src="{{ asset('assets/js/notify.js') }}"></script>
        <script src="{{ asset('account/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
        @stack('scripts')
    </body>
</html>