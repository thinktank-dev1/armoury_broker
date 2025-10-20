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
        <script>
            $(document).ready(function(){
                resetTopPadding();
                $(window).resize(function() {
                    resetTopPadding();
                });
            });
            function resetTopPadding(){
                var headerHeight = $('.header_wrap').height();
                $('.section').first().css('margin-top', headerHeight+'px');
                $('.banner_section').css('margin-top', headerHeight+'px')
            }
        </script>
        @stack('scripts')

        <script>
            let inactivityTime = 0;
            const maxInactivity = 5 * 60;
            const countdownStart = 30;
            let countdownTimer;
            let countdownRemaining = countdownStart;

            function resetTimer() {
                inactivityTime = 0;
                clearInterval(countdownTimer);
                document.getElementById('logout-warning')?.classList.add('hidden');
            }
            
            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onscroll = resetTimer;
            document.onclick = resetTimer;

            setInterval(() => {
                inactivityTime++;
                if(inactivityTime === maxInactivity - countdownStart) {
                    showCountdown();
                }
                if (inactivityTime >= maxInactivity) {
                    window.location.href = "{{ route('logout') }}";
                }
            }, 1000);

            function showCountdown() {
                $('#logout-warning').modal('show');
                countdownRemaining = countdownStart;

                countdownTimer = setInterval(() => {
                    countdownRemaining--;
                    document.getElementById('countdown').innerText = countdownRemaining;

                    if (countdownRemaining <= 0) {
                        clearInterval(countdownTimer);
                    }
                }, 1000);
            }

            function stayLoggedIn() {
                $('#logout-warning').modal('hide');
                fetch("{{ route('keep-alive') }}", { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
                .then(() => resetTimer());
            }
        </script>
    </body>
</html>