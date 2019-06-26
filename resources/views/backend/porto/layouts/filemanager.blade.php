<!doctype html>
<html class="scroll">
<head>
@include('backend.'.config('website.backend').'.layouts.meta')    
@include('backend.'.config('website.backend').'.layouts.script')

</head>
<body>
    <section class="body">
        @include('backend.'.config('website.backend').'.layouts.header')
        <div class="inner-wrapper">
            @include('backend.'.config('website.backend').'.layouts.left-file')
            <section role="main" class="content-body">
                <header class="page-header">
                    <span class="col-lg-11 col-sm-6 col-xl-3 pull-left" style="color:#A6A3A3;margin-top:15px;z-index: 1;">
                        
                    </span>

                    <div class="right-wrapper pull-right">       
                        <a class="sidebar-right-toggle" data-open="sidebar-right">
                            <i style="margin-right: -30px;" class="fa fa-paper-plane"></i>
                        </a>
                    </div>
                </header>
                <!-- start: page -->
                @yield('content')
                <div style="padding-bottom: 30px;"></div>
                <!-- end: page -->
            </section>
        </div>

        {{-- 5b178de98859f57bdc7be288 --}}
        @include('backend.'.config('website.backend').'.layouts.right')
    </section>

    <script src="{{ Helper::backend('javascripts/theme.js') }}" ></script>
    @stack('javascript')
    @stack('style')

</body>
</html>