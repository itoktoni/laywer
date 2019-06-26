<!doctype html>
<html class="scroll">
<head>
@include('backend.'.config('website.backend').'.layouts.meta')    
@include('backend.'.config('website.backend').'.layouts.script')
    
</head>
<body>
    <section class="body">
        <div class="container">
          @include('backend.'.config('website.backend').'.layouts.header')            
                @yield('content')
        </div>
        
    </section>

    <script src="{{ Helper::backend('javascripts/theme.js') }}" ></script>
    <script src="{{ Helper::backend('javascripts/theme.init.js') }}"></script>
    @stack('javascript')
    @include('backend.'.config('website.backend').'.layouts.notif')
    @stack('style')

</body>
</html>