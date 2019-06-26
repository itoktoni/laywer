@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">
    {!! Form::model($data, ['route'=>[$form.'_prepare', $data->$key],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Nomor PO : {{ $data->$key }}</h2>
        </header>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <tbody>
                        <tr>
                            <th class="col-lg-2">Tanggal Order</th>
                            <td>
                                <div class="col-md-3">
                                    <input type="text" name="order_date" readonly="" class="form-control input-sm" value="{{ $data->order_date }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th valign="middle" class="col-lg-2">Status Pengiriman</th>
                            <td>
                                <div class="col-md-3">
                                    {{ Form::select('order_status', ['DELIVERED' => 'DELIVERED', 'COMPLETE' => 'COMPLETE'], null, ['class'=> 'form-control']) }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">File Attachment</th>
                            <td>
                                <div class="col-md-3">
                                    <a class="btn btn-danger" target="_blank" href="{{ asset('public/files/order/'.$data->order_attachment) }}">Download File</a> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Estimasi Cost</th>
                            <td>
                                <div class="col-md-3">
                                    <input type="text" name="estimasi_cost" readonly="" class="form-control input-sm" value="{{ $data->estimasi_cost }}">
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <th class="col-lg-2">Delivery Cost</th>
                            <td>
                                <div class="col-md-3">
                                    <input type="text" name="delivery_cost" class="form-control input-sm" value="{{ $data->delivery_cost }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Air Bill (No. Resi)</th>
                            <td>
                                <div class="col-md-3">
                                    <input type="text" name="airbill" class="form-control input-sm" value="{{ $data->airbill }}">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <header class="panel-heading">
                        <h2 class="panel-title text-right">Actual Delivery</h2>
                    </header>
                    <tr>
                        <th class="col-lg-2">ID Product</th>
                        <th>Product Name</th>
                        <th class="text-right">Pesanan</th>
                        <th class="text-right">Delivery</th>
                        <th class="text-right">Remaining</th>
                    </tr>
                    @php
                    $tot = 0;
                    @endphp
                    @foreach($detail as $c)
                    <tr>
                        @php
                        $tot = $tot + $c->qty_prepare;
                        @endphp
                        <td class="col-lg-2">{{ $c->product_id }}</td>
                        <td>{{ $c->product_name }}</td>
                        <input type="hidden" name="product[]" value="{{ $c->product_id }}">
                        
                        <td class="text-right col-md-2">
                            <input type="text" readonly="" name="receive[]" class="form-control text-right input-sm" value="{{ isset($c->qty) ? $c->qty : 0  }}">
                        </td>
                        <td class="text-right col-md-2">
                            <input type="text" name="delivery[]" readonly="" class="form-control text-right input-sm" value="{{ $c->qty_prepare }}">
                        </td>
                        <td class="text-right">{{ $c->qty - $c->qty_prepare }}</td>
                    </tr>
                    @endforeach
                    <tr class="well default">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right" colspan="5">{{ $tot }}</th>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @isset($prepare)
                @if($data->order_status != 'COMPLETE')
                <button type="submit" class="btn btn-primary">Save</button>
                @endif
                 <a target="_blank" href="{!! route("{$form}_delivery_order", ["code" => $data->$key]) !!}" class="btn btn-danger">Cetak PDF
                </a>    
                @endisset
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}

@endsection