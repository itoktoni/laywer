<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('public/assets/css/print.css') }}" media="all" rel="stylesheet" />
</head>
<body>
    <div id='page'>
        <div style="margin-bottom: 0px;clear: both;">
            <h4 style='text-align: center; color:white;line-height: 0;font-size: 5.2em; font-weight: bold;'>
                ( {{ $data->name }} )
            </h4>

            <h5 style='text-align: center; color:white;line-height: 0;font-size: 5.2em;padding-top: -150px;'> {{ $data->rack_name }} </h5>

            <h5 style="text-align: center;">
                <img style="width: 90%; margin-top: 200px;text-align: center;" src="data:image/png;base64,{{ BARCODE1D::getBarcodePNG($data->rack_id, 'C128',10,200)}}" alt="barcode" />
                <h5>
                </div>
                <hr style="border-style: dashed">
            </div>
        </body>
        </html>


