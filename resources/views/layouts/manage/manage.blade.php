<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    <head>
        <meta charset="utf-8" />
        <title>{{ $data['subtitle'] . ' - ' . $data['title'] }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('img/silab-logo.png') }}">

        <!-- Layout config Js -->
        <script src="{{ asset('assets/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{asset('assets/libs/jquery-ui/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('js/jquery-3.4.1.min.js')}}" type="text/javascript"></script>

        <script src="{{asset('assets/libs/jquery-ui/jquery-ui.js')}}" type="text/javascript"></script>




    </head>

    <body>


        <!-- Begin page -->

        <div id="layout-wrapper">
            @include('layouts.modal')
            @include('layouts.manage._header')
            @include('layouts.manage._sidebar')
            @include('layouts.manage._content')
        </div>

        <!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
       {{--  <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script>


        </script>
    </body>

</html>
