@if (config('website.env') == 'local')
<script src="{{ Helper::backend('vendor/modernizr/modernizr.min.js') }}"></script>
<script src="{{ Helper::backend('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ Helper::backend('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
@else
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
@endif
@stack('js')
<script src="{{ Helper::backend('vendor/pnotify/pnotify.custom.js') }}"></script>
<script src="{{ Helper::backend('javascripts/theme.custom.js') }}"></script>