@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">

    {!! Form::open(['route' => $form.'_penjualan_product',  'method' => 'get', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Report Penjualan By Product</h2>
        </header>

        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label">Tanggal Mulai</label>
                    <div class="col-md-4 {{ $errors->has('date_start') ? 'has-error' : ''}}">
                        <div class="input-group">
                            {!! Form::text('date_start', null, ['class' => 'form-control datepicker']) !!}
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <label class="col-md-2 control-label">Tanggal Akhir</label>
                    <div class="col-md-4 {{ $errors->has('tanggal_end') ? 'has-error' : ''}}">
                        <div class="input-group">
                            {!! Form::text('date_end', null, ['class' => 'form-control datepicker']) !!}
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Supplier</label>
                   <div class="col-md-4 {{ $errors->has('supplier_id') ? 'has-error' : ''}}">
                    <select class="form-control col-md-4 option" name="supplier">
                        @if(Auth::user()->group_user != 'supplier')
                        <option value="">Select Supplier</option>
                        @endif
                        @foreach($supplier as $value)
                        <option @isset($data) {{ $value->supplier_id == $data->supplier_name ? 'selected="selected"' : '' }} @endisset value="{{ $value->supplier_id }}">{{ $value->supplier_name }}</option>
                        @endforeach
                    </select>
                    </div>

                    <label class="col-md-2 control-label">Status Order</label>
                    <div class="col-md-4 {{ $errors->has('status') ? 'has-error' : ''}}">
                        {{ Form::select('status', ['' => 'Pilih Status','OPEN' => 'OPEN','APPROVED' => 'APPROVED', 'PREPARED' => 'PREPARED', 'DELIVERED' => 'DELIVERED', 'COMPLETE' => 'COMPLETE'], null, ['id' => 'kurir','class'=> 'form-control']) }}
                    </div>

                </div>
            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-success">Export Excell</button>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>

@endsection