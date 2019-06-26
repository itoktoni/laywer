<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@php
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = str_replace('/index.php', '', rtrim(dirname($_SERVER['PHP_SELF']), '/\\'));
$path   = str_replace('/setting', '', $path);


if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $protocol = 'http://';
} else {
    $protocol = 'https://';
}

$baseurl = $path . "/file-manager/";
@endphp
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ $path }}/">
    <title>{{ config('app.name', 'File Manager') }}</title>

    <!-- Styles -->

@if (config('website.env') == 'local')
<link rel="stylesheet" type="text/css" href="{{ Helper::backend('vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ Helper::backend('vendor/font-awesome-4.7.0/css/font-awesome.min.css') }}"/>
@else
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endif

    <link href="{{ Helper::vendor('file-manager/css/file-manager.min.css') }}" rel="stylesheet">   

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" id="fm-main-block">
            <div id="fm"></div>
        </div>
    </div>
</div>

<!-- File manager -->
<script src="{{ Helper::vendor('file-manager/js/file-manager.min.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // set fm height
    document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight + 'px');

    const FileBrowserDialogue = {
      init: function() {
        // Here goes your code for setting your custom things onLoad.
      },
      mySubmit: function (URL) {
        // pass selected file path to TinyMCE
        parent.tinymce.activeEditor.windowManager.getParams().setUrl(URL);
        // close popup window
        parent.tinymce.activeEditor.windowManager.close();
      }
    };

    // Add callback to file manager
    fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
        console.log(fileUrl);
      FileBrowserDialogue.mySubmit(fileUrl);
    });
  });
</script>
</body>
</html>

