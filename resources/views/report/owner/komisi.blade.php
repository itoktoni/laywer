@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">

    {!! Form::open(['route' => $form.'_komisi',  'method' => 'get', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title"> Report Komisi </h2>
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
                <hr>
                <div class="form-group">
                   <label class="col-md-2 control-label">Segmentasi</label>
                   <div class="col-md-4 {{ $errors->has('segmentasi_id') ? 'has-error' : ''}}">
                    <select class="form-control col-md-4 option" name="segmentasi">
                        <option value="">Select Segmentasi</option>
                        @foreach($segmentasi as $value)
                        <option @isset($data) {{ $value->segmentasi_id == $data->product_segmentasi ? 'selected="selected"' : '' }} @endisset value="{{ $value->segmentasi_id }}">{{ $value->segmentasi_name }}</option>
                        @endforeach
                    </select>
                    </div>
                    <label class="col-md-2 control-label">Size</label>
                    <div class="col-md-4 {{ $errors->has('size_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="option4" name="size">
                            <option value="">Select Size</option>
                            @foreach($size as $value)
                            <option @isset($data) {{ $value->size_name == $data->product_size ? 'selected="selected"' : '' }} @endisset value="{{ $value->size_name }}">{{ $value->size_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Customer</label>
                   <div class="col-md-4 {{ $errors->has('customer_id') ? 'has-error' : ''}}">
                    <select class="form-control col-md-4 option" name="customer">
                        <option value="">Select Customer</option>
                        @foreach($customer as $value)
                        <option @isset($data) {{ $value->customer_id == $data->customer_name ? 'selected="selected"' : '' }} @endisset value="{{ $value->customer_id }}">{{ $value->customer_name }}</option>
                        @endforeach
                    </select>
                    </div>
                    <label class="col-md-2 control-label">Product Category</label>
                    <div class="col-md-4 {{ $errors->has('product_category') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="option" name="category">
                            <option value="">Select Category</option>
                            @foreach($category as $value)
                            <option @isset($data) {{ $value->category_id == $data->product_category ? 'selected="selected"' : '' }} @endisset value="{{ $value->category_name }}">{{ $value->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                 <div class="form-group">
                   <label class="col-md-2 control-label">Sales</label>
                   <div class="col-md-4 {{ $errors->has('sales_id') ? 'has-error' : ''}}">
                    <select class="form-control col-md-4 option1" name="sales">
                        <option value="">Select Sales</option>
                        @foreach($sales as $value)
                        <option @isset($data) {{ $value->email == $data->email ? 'selected="selected"' : '' }} @endisset value="{{ $value->email }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                    </div>

                   <label class="col-md-2 control-label">Komisi</label>
                   <div class="col-md-4 {{ $errors->has('komisi') ? 'has-error' : ''}}">
                    {!! Form::text('komisi', config('website.komisi'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Jasa Kurir</label>
                    <div class="col-md-4 {{ $errors->has('courier') ? 'has-error' : ''}}">
                        {{ Form::select('kurir', ['' => 'Pilih Paket','pos' => 'POS - POS Indonesia', 'jne' => 'JNE - Jalur Nugraha Ekakurir','tiki' => 'TIKI - Citra Van Titipan Kilat'], null, ['id' => 'kurir','class'=> 'form-control']) }}
                    </div>

                    <label class="col-md-2 control-label">Status Order</label>
                    <div class="col-md-4 {{ $errors->has('status') ? 'has-error' : ''}}">
                        {{ Form::select('status', ['' => 'Pilih Status','CONFIRM' => 'CONFIRM','APPROVED' => 'APPROVED', 'PAID' => 'PAID', 'PREPARED' => 'PREPARED', 'DELIVERED' => 'DELIVERED', 'COMPLETE' => 'COMPLETE'], null, ['id' => 'kurir','class'=> 'form-control']) }}
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