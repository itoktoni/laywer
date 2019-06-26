<!doctype html>
<html class="fixed">
    <head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="csrf-token" value="{{ csrf_token() }}">

<title>{{ config('app.name') }}</title>

 <link href="{{ Helper::files('logo/'.config('website.favicon','default_favicon.png')) }}" rel="shortcut icon">

<meta name="keywords" content="{{ config('app.name') }}" />
<meta name="description" content="{{ config('app.name') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

@if (config('website.env') == 'local')
<link rel="stylesheet" type="text/css" href="{{ Helper::backend('vendor/bootstrap/css/bootstrap.min.css') }}">
@else
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css">
@endif

@stack('css')
<link rel="stylesheet" href="{{ Helper::backend('stylesheets/theme.min.css') }}"/>
<link rel="stylesheet" href="{{ Helper::backend('stylesheets/skins/default.min.css') }}"/>
<link rel="stylesheet" href="{{ Helper::backend('stylesheets/theme-custom.css') }}">

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
                            <img src="{{ Helper::backend('/images/error.png') }}" class="img-circle user-image" />

                        </div>

                        <div class="form-group mb-lg">
                            <div class="input-group input-group-icon">
                                <h1 class="user-name text-center text-danger m-none">Permision Deny !</h1>
                                <br>
                                <h4 class="user-email text-center text-dark m-none"> Unauthorized Action for This Pages ! </h4>
                                <hr>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <div class="btn btn-group">
                                    <a class="btn btn-dark" href="{!! route('reset') !!}">Logout</a>
                                    <a class="btn btn-danger" href="{!! route('home') !!}">Back To Page</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- end: page -->

    </body>
</html>