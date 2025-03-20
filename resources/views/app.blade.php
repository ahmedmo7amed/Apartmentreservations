<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../../storage/assets/js/vendor/modernizr.min.js"></script>
    <!-- jQuery JS -->
    <script src="../../storage/assets/js/vendor/jquery.js"></script>
    <!-- Bootstrap JS -->
    <script src="../../storage/assets/js/vendor/bootstrap.min.js"></script>
    <!-- sal.js -->
    <script src="../../storage/assets/js/vendor/sal.js"></script>
    <script src="../../storage/assets/js/vendor/magnify.min.js"></script>
    <script src="../../storage/assets/js/vendor/jquery-appear.js"></script>
    <script src="../../storage/assets/js/vendor/odometer.js"></script>
    <script src="../../storage/assets/js/vendor/backtotop.js"></script>
    <script src="../../storage/assets/js/vendor/isotop.js"></script>
    <script src="../../storage/assets/js/vendor/imageloaded.js"></script>

    <script src="../../storage/assets/js/vendor/wow.js"></script>
    <script src="../../storage/assets/js/vendor/waypoint.min.js"></script>
    <script src="../../storage/assets/js/vendor/easypie.js"></script>
    <script src="../../storage/assets/js/vendor/text-type.js"></script>
    <script src="../../storage/assets/js/vendor/jquery-one-page-nav.js"></script>
    <script src="../../storage/assets/js/vendor/bootstrap-select.min.js"></script>
    <script src="../../storage/assets/js/vendor/jquery-ui.js"></script>
    <script src="../../storage/assets/js/vendor/magnify-popup.min.js"></script>
    <script src="../../storage/assets/js/vendor/paralax-scroll.js"></script>
    <script src="../../storage/assets/js/vendor/paralax.min.js"></script>
    <script src="../../storage/assets/js/vendor/countdown.js"></script>
    <script src="../../storage/assets/js/vendor/plyr.js"></script>
    <!-- Main JS -->
    <script src="../../storage/assets/js/main.js"></script>

</html>
