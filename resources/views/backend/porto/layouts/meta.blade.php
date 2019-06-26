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
<link rel="stylesheet" href="{{ Helper::backend('vendor/font-awesome-4.7.0/css/font-awesome.min.css') }}"/>
@else
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endif

@stack('css')
<link rel="stylesheet" href="{{ Helper::backend('vendor/pnotify/pnotify.custom.css') }}" />
<link rel="stylesheet" href="{{ Helper::backend('stylesheets/theme.min.css') }}"/>
<link rel="stylesheet" href="{{ Helper::backend('stylesheets/skins/default.min.css') }}"/>
<link rel="stylesheet" href="{{ Helper::backend('stylesheets/theme-custom.css') }}">