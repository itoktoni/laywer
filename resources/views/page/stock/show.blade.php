@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Detail Barang {{ $data->product_code }}</h2>
        </header>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <tr>
                        <th class="col-lg-2">Barcode</th>
                        <th class="text-right">Rack Name</th>
                        <th class="text-right">Warehouse Name</th>
                        <th class="text-right">User</th>
                        <th class="text-right">Stock</th>
                    </tr>
                    @php
                    $tot = 0;
                    @endphp
                    @foreach($detail as $c)
                    <tr>
                        @php
                        $tot = $tot + $c->qty;
                        @endphp
                        <td class="col-lg-2">{{ $c->barcode }}</td>
                        <td class="text-right">{{ $c->rack_name }}</td>
                        <td class="text-right">{{ $c->warehouse_name }}</td>
                        <td class="text-right">{{ $c->created_by }}</td>
                        <td class="text-right">
                            @if(session()->get('akses.revisi'))
                            <a href="{!! route("{$form}_revisi", ["code" => $c->barcode ]) !!}" class="btn btn-primary btn-xs"> Revisi : {{ $c->qty }} </a>
                            @else
                            {{ $c->qty }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr class="well default">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right" colspan="5">{{ $tot }}</th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("stock_real") !!}" class="btn btn-warning">Back</a>
                @isset($print_stock_real)
                <a target="_blank" href="{!! route("{$form}_print_stock_real", ["code" => $data->product_code ]) !!}" class="btn btn-danger">Cetak Opname
                </a>
                @endisset
            </div>
        </div>

    </div>
</div>

@endsection