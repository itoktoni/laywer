<!DOCTYPE html>
<html lang="en">

<head>
   <title>{{ config('website.name', 'Laravel') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <link href="{{ Helper::files('logo/'.config('website.favicon','default_favicon.png')) }}" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="{{ Helper::credential('default/css/style.css') }}">
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <!-- Icon -->
            <div class="fadeIn first">
                <img src="{{ Helper::files('logo/'.config('website.logo')) }}" id="icon" alt="User Icon" />
            </div>
            <!-- Login Form -->

             @yield('content')
            
            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="{{ url('/password/reset') }}">Forgot Password?</a>
            </div>
        </div>
    </div>
</body>

</html>
