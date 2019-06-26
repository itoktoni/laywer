<!doctype html>
<html class="scroll">
<head>
@include('backend.'.config('website.backend').'.layouts.meta')    
@include('backend.'.config('website.backend').'.layouts.script')
    
    <script type="text/javascript">
        var start_time = +new Date();
        window.onload = function() {
            var time = ((+new Date() - start_time) / 1000);
            var data = time + ' Second';
            document.getElementById("pageload").textContent=data;
        };
    </script>
</head>
<body>
    <section class="body">
        @include('backend.'.config('website.backend').'.layouts.header')
        <div class="inner-wrapper">
            @include('backend.'.config('website.backend').'.layouts.left')
            <section role="main" class="content-body">
                <header class="page-header">
                    <span class="col-lg-11 col-sm-6 col-xl-3 pull-left" style="color:#A6A3A3;margin-top:15px;z-index: 1;">
                        <marquee>
                            <div style="float: left;">Page Load :&ensp;</div>
                            <div id="pageload" style="float:left;"></div>
                            <?php
                            function echo_memory_usage()
                            {
                                $kata = ", Memory Usage ";
                                $mem_usage = memory_get_usage(true);
                                if($mem_usage < 1024)
                                    echo $kata.$mem_usage." bytes";
                                elseif($mem_usage < 1048576)
                                    echo $kata.round($mem_usage / 1024, 2)." KB";
                                else
                                    echo $kata.round($mem_usage / 1048576, 2)." MB";
//                                    echo "<br/>";
                            }

                            echo_memory_usage();
                            ?>
                        </marquee>
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
    <script src="{{ Helper::backend('javascripts/theme.init.js') }}"></script>
    @stack('javascript')
    @include('backend.'.config('website.backend').'.layouts.notif')
    @stack('style')

</body>
</html>