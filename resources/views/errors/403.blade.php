<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    <head>

        <meta charset="utf-8" />
        <title>403 - Sistem Informasi Laboratorium</title>
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


    </head>

    <body>

        <!-- auth-page wrapper -->
        <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">

            <!-- auth-page content -->
            <div class="auth-page-content overflow-hidden p-0">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-8">
                            <div class="text-center">
                                <img src="{{ url(asset('img/system/coming-soon-img.png')) }}" alt="error img" class="img-fluid">
                                <div class="mt-3">
                                    <h3 class="text-uppercase">Sorry, User Does Not Have The Right Permissions😭</h3>
                                    <p class="text-muted mb-4">The page you are looking for not available!</p>
                                    <a href="{{url('/')}}" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Back to home</a>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth-page content -->
        </div>
        <!-- end auth-page-wrapper -->

    </body>

</html>
