<!DOCTYPE html>
<html>
<head>
	<link href="{{ asset('public/assets/css/print.css') }}" media="all" rel="stylesheet" />
</head>
<body>
	<div id='page'>
		<h4 style='text-align: center;margin-top: -10px; color:white;line-height: 0;font-size: 1.2em; font-weight: bold;'>
			( Penjualan {{ $data->name }} - {{ $data->email }} )
		</h4>
		<hr>
		
		<table border='0' style="margin-top: 10px;clear: both;" cellpadding='5' cellspacing='0' id='templateList' width='100%'>
			<tr>
				<th colspan='7' style='background: #a30046 !important'></th>
			</tr>
			<tr>
				<td align='left' colspan='1' style='width:60px; background-color: #e0e0e0 !important' valign='top'>
					<strong>Order ID</strong>
				</td>
				<td align='left' colspan='1' style='width: 70px; background-color: #e0e0e0 !important;' valign='top'>
					<strong>Create Date</strong>
				</td>
				<td align='left' colspan='1' style='width: 100px; background-color: #e0e0e0 !important' valign='top'>
					<strong>Customer</strong>
				</td>

				<td align='right' colspan='1' style='background-color: #e0e0e0 !important;border-right: 1px solid black;width: 200px;' valign='top'>
					<strong>Product</strong>
				</td>

				<td align='left' colspan='1' style='width: 30px; background-color: #e0e0e0 !important' valign='top'>
					<strong>Pcs</strong>
				</td>

				<td align='left' colspan='1' style='width: 50px; background-color: #e0e0e0 !important' valign='top'>
					<strong>Harga</strong>
				</td>

				<td align='right' colspan='1' style='width: 50px; background-color: #e0e0e0 !important' valign='top'>
					<strong>Total</strong>
				</td>
				
			</tr>
			@php
			$total = 0;
			$fix = 0;
			@endphp
			@foreach($detail as $c)
			<tr>
				@php
				$fix = $c->price * $c->qty_prepare;
				$total = $total + $fix;
				@endphp

				<td class="col-lg-1">{{ $c->order_id }}</td>
				<td class="text-right">{{ $c->order_date }}</td>
				<td class="text-right">{{ $c->customer_name }}</td>
				<td class="text-right" align="right" style="width: 200px;">
					{{ $c->product_name }}
				</td>
				<td class="text-center"> {{ $c->qty_prepare }}</td>
				<td class="text-left">{{ number_format($c->price) }}</td>
				<td class="text-right" align="right">{{ number_format($fix) }}</td>
			</tr>
			@endforeach
			<tr class="well default">
				<th class="text-right" colspan="6">Jumlah</th>
				<th class="text-right" align="right" colspan="1">{{ number_format($total) }}</th>
			</tr>
			
		</tr>
	</table>
</div>
</body>
</html>


