@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Nomor Order {{ $data->$key }}</h2>
        </header>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <tbody>

                        @foreach($fields as $item => $value)
                        <tr>
                            <th class="col-lg-2">{{ $value }}</th>
                            <td>{{ $data->$item }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th class="col-lg-2">Origin From</th>
                            <td>
                                Provinsi {{ $from['province'] }} {{ $from['type'] }} {{ $from['city_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Deliver To</th>
                            <td>
                                Provinsi {{ $to['province'] }} {{ $to['type'] }} {{ $to['city_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Jasa Pengiriman</th>
                            <td>
                                {{ strtoupper($data->courier) }} - {{ $data->courier_service }}
                            </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Total Estimasi</th>
                            <td>
                                Rp. {{ number_format($data->estimasi_cost) }}
                            </td>
                        </tr>
                        <tr><th class="col-lg-2">Customer Address</th><td>{{ $data->order_address }}</td></tr>
                        <tr><th class="col-lg-2">File Attachment</th><td><a class="btn btn-xs btn-danger" target="_blank" href="{{ asset('public/files/document/'.$data->order_attachment) }}">{{ $data->order_attachment }}</a> </td></tr>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>

                <header class="panel-heading">
                    <h2 class="panel-title text-right">Sales Order</h2>
                </header>

                <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <tr>
                        <th class="col-lg-2">ID Product</th>
                        <th>Product Name</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Value</th>
                    </tr>
                    @php
                    $tot = 0;
                    @endphp
                    @foreach($detail as $c)
                    @php
                    $tot = $tot + $c->total;
                    @endphp
                    <tr>
                        <td class="col-lg-2">{{ $c->product_id }}</td>
                        <td>{{ $c->product_name }}</td>
                        <td class="text-right">{{ $c->qty }}</td>
                        <td class="text-right">{{ number_format($c->price) }}</td>
                        <td class="text-right">{{ number_format($c->total) }}</td>
                    </tr>
                    @endforeach
                    <tr class="well default">
                        <th class="text-right" colspan="4">Estimasi Pengiriman</th>
                        <th class="text-right" colspan="5">{{ number_format($c->estimasi_cost) }}</th>
                    </tr>
                    <tr class="well default">
                        <th class="text-right" colspan="4">Sub Total</th>
                        <th class="text-right" colspan="5">{{ number_format($tot) }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr class="well default">
                        <th class="text-right" colspan="4">Total Payment</th>
                        <th class="text-right" colspan="5">{{ number_format($tot + $c->estimasi_cost) }}</th>
                    </tr>
                </table>

                <header class="panel-heading">
                    <h2 class="panel-title text-right">Actual Delivery</h2>
                </header>

                <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <tr>
                        <th class="col-lg-2">ID Product</th>
                        <th>Product Name</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Value</th>
                    </tr>
                    @php
                    $tot_del = 0;
                    @endphp
                    @foreach($detail as $c)
                    @php
                    $harga = $c->price * $c->qty_prepare;
                    $tot_del = $tot_del + $harga;
                    @endphp
                    <tr>
                        <td class="col-lg-2">{{ $c->product_id }}</td>
                        <td>{{ $c->product_name }}</td>
                        <td class="text-right">{{ $c->qty_prepare }}</td>
                        <td class="text-right">{{ number_format($c->price,0,",",".") }}</td>
                        <td class="text-right">{{ number_format($harga,0,",",".") }}</td>
                    </tr>
                    @endforeach
                    <tr class="well default">
                        <th class="text-right" colspan="4">Real Pengiriman</th>
                        <th class="text-right" colspan="5">{{ number_format($c->delivery_cost) }}</th>
                    </tr>
                    <tr class="well default">
                        <th class="text-right" colspan="4">Sub Total</th>
                        <th class="text-right" colspan="5">{{ number_format($tot_del) }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr class="well default">
                        <th class="text-right" colspan="4">Total Tagihan</th>
                        <th class="text-right" colspan="5">{{ number_format($tot_del + $c->delivery_cost) }}</th>
                    </tr>
                     <tr class="well default">
                        <th class="text-right" colspan="4">Total Pembayaran</th>
                        <th class="text-right" colspan="5">{{ number_format($payment) }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr class="well default">
                        <th class="text-right" colspan="4">Sisa Tagihan</th>
                        <th class="text-right" colspan="5">{{ number_format(($tot_del + $c->delivery_cost) - $payment) }}</th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                @isset($update)
                <a href="{!! route("{$form}_update", ["code" => $data->$key]) !!}" class="btn btn-primary">Edit</a>
                @endisset
                @isset($cetak)
                <a target="_blank" href="{!! route("{$form}_cetak", ["code" => $data->$key]) !!}" class="btn btn-danger">Cetak SO
                </a>
                @endisset
                @isset($invoice)
                <a target="_blank" href="{!! route("{$form}_invoice", ["code" => $data->$key]) !!}" class="btn btn-danger">Cetak Invoice
                </a>
                @endisset
            </div>
        </div>

    </div>
</div>

@endsection