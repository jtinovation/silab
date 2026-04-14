<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    <head>
        
        <meta charset="utf-8" />
        <title>{{ config('app.name') }} | Log in</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ url(asset('img/silab-logo.png')) }}">

        <!-- Layout config Js -->
        <script src="{{ url(asset('assets/js/layout.js')) }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ url(asset('assets/css/bootstrap.min.css')) }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ url(asset('assets/css/icons.min.css')) }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ url(asset('assets/css/app.min.css')) }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ url(asset('assets/css/custom.min.css')) }}" rel="stylesheet" type="text/css" />

        <style>
            #auth-particles { background-image: none; }
        </style>

    </head>

    <body>

		@yield('content')

        <!-- JAVASCRIPT -->
        <script src="{{ url(asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')) }}"></script>
        <script src="{{ url(asset('assets/libs/simplebar/simplebar.min.js')) }}"></script>
        <script src="{{ url(asset('assets/libs/node-waves/waves.min.js')) }}"></script>
        <script src="{{ url(asset('assets/libs/feather-icons/feather.min.js')) }}"></script>
        <script src="{{ url(asset('assets/js/pages/plugins/lord-icon-2.1.0.js')) }}"></script>
        <script src="{{ url(asset('assets/js/plugins.js')) }}"></script>

        <!-- particles js -->
        <script src="{{ url(asset('assets/libs/particles.js/particles.js')) }}"></script>
        <!-- particles app js -->
        <script src="{{ url(asset('assets/js/pages/particles.app.js')) }}"></script>
        <!-- password-addon init -->
        <script src="{{ url(asset('assets/js/pages/password-addon.init.js')) }}"></script>
    </body>

</html>