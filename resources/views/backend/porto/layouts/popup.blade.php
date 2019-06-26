<!doctype html>
<html class="scroll">
<head>
    @include('backend.'.config('website.backend').'.layouts.meta')
    @include('backend.'.config('website.backend').'.layouts.script')
</head>
<body>

    <section role="main" class="content-body">
        @yield('content')
    </section>

    <script src="{{ asset('public/assets/javascripts/theme.js') }}" ></script>
    <script src="{{ asset('public/assets/javascripts/theme.init.js') }}"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
            $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd'});
            $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
            $("#datepicker3").datepicker({dateFormat: 'yy-mm-dd'});
            $("#datepicker4").datepicker({dateFormat: 'yy-mm-dd'});
            $("#option").select2();
            $("#option2").select2();
            $("#option3").select2();
            $("#option4").select2();
            $("#option5").select2();
        });
    </script>
    @yield('javascript')
    @include('backend.'.config('website.backend').'.layouts.notif')

</body>
</html>