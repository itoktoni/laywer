<!DOCTYPE html>
<html>
<head>
	<link href="{{ asset('public/assets/css/print.css') }}" media="all" rel="stylesheet" />
</head>
<body>
	<div id='page'>
		<h4 style='text-align: center;margin-top: -10px; color:white;line-height: 0;font-size: 1.2em; font-weight: bold;'>
			( {{ $data->product_id }} - {{ $data->product_name }} )
		</h4>

		 <h5 style="text-align: center;">
                    <img style="margin-top: 10px;text-align: center;" src="data:image/png;base64,{{BARCODE1D::getBarcodePNG($data->product_id, 'C128')}}" alt="barcode"/>
                    <h5>

		<hr>
		
		<table border='0' style="margin-top: 10px;clear: both;" cellpadding='5' cellspacing='0' id='templateList' width='100%'>
			<tr>
				<th colspan='8' style='background: #a30046 !important'></th>
			</tr>
			<tr>
				<td align='left' width="60px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
					<strong>Barcode</strong>
				</td>
				<td align='left' width="120px" colspan='1' style='background-color: #e0e0e0 !important;' valign='top'>
					<strong>Rack Warehouse</strong>
				</td>
				<td align='left' width="80px" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
					<strong>Opname Date</strong>
				</td>

				<td align='left' colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
					<strong>Valid</strong>
				</td>

				<td align='right' colspan='1' style='background-color: #e0e0e0 !important;border-right: 1px solid black;width: 80px;' valign='top'>
					<strong>Checked By</strong>
				</td>

				<td align='right' colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
					<strong>Stock</strong>
				</td>

				<td align='right' colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
					<strong>Opname</strong>
				</td>

				<td align='right' colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
					<strong>Hasil</strong>
				</td>
			</tr>
			@php
			$tot = 0;
			@endphp
			@foreach($detail as $c)
			<tr>
				@php
				$valid = $c->qty == 0 ? 0 : $c->qty;
				$tot = $tot + $c->qty;

				@endphp
				<td class="col-lg-1">{{ $c->barcode }}</td>
				<td class="text-right">{{ $c->warehouse_name }} - {{ $c->rack_name }}</td>
				<td class="text-right">{{ $c->checked_at }}</td>
				<td class="text-right">{{ $c->valid == 0 ? 'Not Valid' : 'Valid' }}</td>
				<td class="text-right" align="right" style="width: 80px;">{{ $c->checked_by }}</td>
				<td class="text-right" align="right">{{ $c->qty }}</td>
				<td class="text-right" align="right">{{ $valid }}</td>
				<td class="text-right" align="right">{{ $c->qty - $valid }}</td>
			</tr>
			@endforeach
			<tr class="well default">
				<th class="text-right" colspan="7">Total</th>
				<th class="text-right" align="right" colspan="1">{{ $tot }}</th>
			</tr>
		</tr>
	</table>
</div>
</body>
</html>


