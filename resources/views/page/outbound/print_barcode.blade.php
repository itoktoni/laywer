<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('public/assets/css/print.css') }}" media="all" rel="stylesheet" />
</head>
<body>
    <div id='page'>
        <div style="margin-bottom: 0px;margin-top:-35px;clear: both;">
            <h4 style='text-align: center; color:white;line-height: 0;font-size: 1em; font-weight: bold;'>
                {{ $data->product_id }} - ( {{ $data->qty }} ) {{ strtoupper($data->product_unit) }}
            </h4>

            <img style="margin-top: 25px;width: 100%; text-align: center;" src="data:image/png;base64,{{BARCODE1D::getBarcodePNG($code.'#'.$data->product.'#'.$data->qty, 'C128')}}" alt="barcode" />

            <h5 style='text-align: center; padding-top:10px;color:white;line-height: 0;font-size: 1em; font-weight: bold;'>
                {{ $data->product_name }}
            </h5>
            <p style="text-align: center;padding-top: 10px;">Barcode{{ $data->unic }}</p>
        </div>

    </div>
</body>
</html>