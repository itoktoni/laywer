<!doctype html>
<html class="fixed">
    <head>

        <meta charset="UTF-8">
        <meta name="keywords" content="{{ config('app.name', 'Laravel') }}" />
        <meta name="description" content="{{ config('app.name', 'Laravel') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">-->
        <link rel="stylesheet" href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/assets/vendor/font-awesome/css/font-awesome.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/assets/stylesheets/theme.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/assets/stylesheets/skins/default.css') }}" />
        <link rel="stylesheet" href="{{ asset('public/assets/stylesheets/theme-custom.css') }}">
        <script src="{{ asset('public/assets/vendor/modernizr/modernizr.js') }}"></script>

        <script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?></script>

        <style>
            .body-locked .current-user .user-image{
                border-color: #CC010C;
            }

            .body-sign .panel-sign .panel-body{
                border-color: #CC010C;
            }
        </style>

    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign body-locked">
            <div class="center-sign">
                <div class="panel panel-sign">
                    <div class="panel-body"> 
                        <div class="current-user text-center">
                            <img src="{{ asset('public/assets/images/error.png') }}" alt="{{ Auth::user()->name }}" class="img-circle user-image" />

                        </div>

                        <div class="form-group mb-lg">
                            <div class="input-group input-group-icon">
                                <h1 class="user-name text-center text-danger m-none">Error Permission !</h1>
                                <br>
                                <h5 class="user-email text-center text-dark m-none">
                                    You are not authorized to this page !
                                </h5>
                                <hr>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <div class="btn btn-group">
                                    <a class="btn btn-dark" href="{!! route('reset') !!}">Logout</a>
                                    <a class="btn btn-danger" href="{!! URL::previous() !!}">Back To Page</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- end: page -->


        <!-- Vendor -->
        <script src="{{ asset('public/assets/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/magnific-popup/magnific-popup.js') }}"></script>
        <script src="{{ asset('public/assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="{{ asset('public/assets/javascripts/theme.js') }}"></script>

        <!-- Theme Custom -->
        <script src="{{ asset('public/assets/javascripts/theme.custom.js') }}"></script>

        <!-- Theme Initialization Files -->
        <script src="{{ asset('public/assets/javascripts/theme.init.js') }}"></script>


    </body>
</html>