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
                        <tr><th class="col-lg-2">File Attachment</th><td><a class="btn btn-xs btn-danger" target="_blank" href="{{ asset('public/files/po/'.$data->purchase_attachment) }}">{{ $data->purchase_attachment }}</a> </td></tr>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>

                <header class="panel-heading">
                    <h2 class="panel-title text-right">Order Admin</h2>
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
                    <tr>

                        @php
                        $tot = $tot + $c->total;
                        @endphp
                        <td class="col-lg-2">{{ $c->product_id }}</td>
                        <td>{{ $c->product_name }}</td>
                        <td class="text-right">{{ $c->qty }}</td>
                        <td class="text-right">{{ number_format($c->price,0,",",".") }}</td>
                        <td class="text-right">{{ number_format($c->total,0,",",".") }}</td>
                    </tr>
                    @endforeach
                    <tr class="well default">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right" colspan="5">{{ number_format($tot,0,",",".") }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
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
                    $tot_supplier = 0;
                    @endphp
                    @foreach($detail as $c)
                    <tr>
                        @php
                        $tot_supplier = $tot_supplier + $c->total_prepare;
                        @endphp
                        <td class="col-lg-2">{{ $c->product_id }}</td>
                        <td>{{ $c->product_name }}</td>
                        <td class="text-right">{{ $c->qty_prepare }}</td>
                        <td class="text-right">{{ number_format($c->price_prepare,0,",",".") }}</td>
                        <td class="text-right">{{ number_format($c->total_prepare,0,",",".") }}</td>
                    </tr>
                    @endforeach
                    <tr class="well default">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right" colspan="5">{{ number_format($tot_supplier,0,",",".") }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </table>
                
                @if($payment->count() > 0)
                <header class="panel-heading">
                    <h2 class="panel-title text-right">Payment</h2>
                </header>

                <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <tr>
                        <th class="col-lg-2">Payment Voucher</th>
                        <th>Payment Date</th>
                        <th class="text-right">Description</th>
                        <th class="text-right">Created By</th>
                        <th class="text-right">Value</th>
                    </tr>
                    @php
                    $tot_payment = 0;
                    @endphp
                    @foreach($payment as $p)
                    <tr>
                        @php
                        $tot_payment = $tot_payment + $p->approve_amount;
                        @endphp
                        <td class="col-lg-2">{{ $p->payment_voucher }}</td>
                        <td>{{ $p->payment_date }}</td>
                        <td class="text-right">{{ $p->payment_description }}</td>
                        <td class="text-right">{{ $p->approved_by }}</td>
                        <td class="text-right">{{ number_format($p->approve_amount) }}</td>
                    </tr>
                    @endforeach
                    <tr class="well default">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right" colspan="5">{{ number_format($tot_supplier,0,",",".") }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </table>
                @endif
            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                @isset($update)
                <a href="{!! route("{$form}_update", ["code" => $data->$key]) !!}" class="btn btn-primary">Edit</a>
                @endisset
                @isset($print_approval)
                <a target="_blank" href="{!! route("{$form}_print_approval", ["code" => $data->$key]) !!}" class="btn btn-danger">Cetak Approve PDF
                </a>
                @endisset
                @isset($print_delivery)
                <a target="_blank" href="{!! route("{$form}_print_delivery", ["code" => $data->$key]) !!}" class="btn btn-danger">Cetak Delivery
                </a>
                @endisset
                @if(isset($print_invoice) && $data->purchase_status == 'DELIVERED')
                <a target="_blank" href="{!! route("{$form}_print_invoice", ["code" => $data->$key]) !!}" class="btn btn-danger">Cetak Invoice
                </a>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection