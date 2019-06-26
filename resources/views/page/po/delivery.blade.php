@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">
    {!! Form::model($data, ['route'=>[$form.'_'.$action, $data->$key],'class'=>'form-horizontal','files'=>true]) !!}
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
                                    <input type="text" name="purchase_date" readonly="" class="form-control input-sm" value="{{ $data->purchase_date }}">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th valign="middle" class="col-lg-2">Tanggal Pengiriman</th>
                            <td>
                                <div class="col-md-3">
                                    <input type="text" name="purchase_delivery_date" id="datepicker" class="form-control input-sm datepicker" value="{{ $data->purchase_delivery_date }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th valign="middle" class="col-lg-2">Status Pengiriman</th>
                            <td>
                                <div class="col-md-3">
                                    {{ Form::select('purchase_status', ['APPROVED' => 'APPROVED', 'PREPARED' => 'PREPARED','DELIVERED' => 'DELIVERED'], null, ['class'=> 'form-control']) }}
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th class="col-lg-2">File Attachment</th>
                            <td>
                                <div class="col-md-3">
                                    <a class="btn btn-danger" target="_blank" href="{{ asset('public/files/po/'.$data->purchase_attachment) }}">Download File</a> 
                                </div>
                                
                            </td>
                        </tr> 
                        <tr>
                            <th class="col-lg-2">Note Supplier</th>
                            <td>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="2" name="purchase_note_supplier" cols="50">{{ $data->purchase_note_supplier }}</textarea>
                                </div>                               
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-table table-bordered table-striped table-hover mb-none">

                    <header class="panel-heading">
                        <h2 class="panel-title text-right">Order From Admin</h2>
                    </header>

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

                <table class="table table-table table-bordered table-striped table-hover mb-none">

                    <header class="panel-heading">
                        <h2 class="panel-title text-right">Actual Delivery</h2>
                    </header>

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
                        $tot = $tot + $c->total_prepare;
                        @endphp
                        <td class="col-lg-2">{{ $c->product_id }}</td>
                        <td>{{ $c->product_name }}</td>
                        <input type="hidden" name="product[]" value="{{ $c->product_id }}">
                        <td class="text-right col-md-2">
                            <input type="text" name="qty[]" {{ $data->purchase_status != 'APPROVED' ? 'readonly=""' : ''}} class="form-control text-right input-sm" value="{{ empty($c->qty_prepare) ? 0 : $c->qty_prepare }}">
                        </td>
                        <td class="text-right col-md-2">
                            <input type="text" name="price[]" readonly="" class="form-control text-right input-sm" value="{{ $c->price }}">
                        </td>
                        <td class="text-right">{{ number_format($c->total_prepare,0,",",".") }}</td>
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
            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @isset($delivery)
                @if($data->purchase_status == 'APPROVED')
                <button type="submit" class="btn btn-primary">Save</button>
                @endif
                @endisset
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}

@endsection