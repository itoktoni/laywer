<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css" href="{{ Helper::backend('vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
<link rel="stylesheet" href="{{ Helper::vendor('file-manager/css/file-manager.css') }}">

	<title>Document</title>
</head>
<body>
	<div style="height: 600px;">
    <div id="fm"></div>
</div>
</body>
<script src="{{ Helper::vendor('file-manager/js/file-manager.js') }}"></script>
</html>