<!doctype html>
<html class="scroll">
<head>
@include('backend.'.config('website.backend').'.layouts.meta')    
@include('backend.'.config('website.backend').'.layouts.script')
    
</head>
<body>
    <section class="body">
        @include('backend.'.config('website.backend').'.layouts.header')
        <div class="container">            
        <div class="inner-wrapper">
            <section role="main" class="content-body">
                <!-- start: page -->
                @yield('content')
                <div style="padding-bottom: 30px;"></div>
                <!-- end: page -->
            </section>
        </div>
        </div>
        
    </section>

    <script src="{{ Helper::backend('javascripts/theme.js') }}" ></script>
    <script src="{{ Helper::backend('javascripts/theme.init.js') }}"></script>
    @stack('javascript')
    @include('backend.'.config('website.backend').'.layouts.notif')
    @stack('style')

</body>
</html>