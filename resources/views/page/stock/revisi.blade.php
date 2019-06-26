@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">
    {!! Form::model($data, ['route'=>[$form.'_revisi', $data->$key],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Edit {{ ucwords(str_replace('_',' ',$template)) }} {{ $data->$key }}</h2>
        </header>
        <div class="panel-body">
            <div class="col-md-12 col-lg-12">

                <div class="form-group">
                    
                    <label class="col-md-2 control-label">Rack</label>
                    <div style="margin-bottom: 5px;" class="col-md-3 {{ $errors->has('rack_code') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="option" name="rack_code">
                            <option value="">Select Rack</option>
                            @foreach($rack as $value)
                            <option @isset($data) {{ $value->rack_id == $data->rack_code ? 'selected="selected"' : '' }} @endisset value="{{ $value->rack_id }}">{{ $value->rack_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <label class="col-md-1 control-label">Qty</label>
                    <div class="col-md-2 {{ $errors->has('qty') ? 'has-error' : ''}}">
                        {!! Form::text('qty', null, ['class' => 'form-control']) !!}
                    </div>

                    <label class="col-md-1 control-label">Type</label>
                    <div class="col-md-3">
                        {{ Form::select('wh_type', ['IN' => 'BARANG MASUK', 'OUT' => 'BARANG KELUAR', 'BROKEN' => 'BARANG RUSAK'], null, ['class'=> 'form-control']) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="navbar-fixed-bottom" id="menu_action">
        <div class="text-right" style="padding:5px">
            <a href="{!! route("{$form}_real") !!}" class="btn btn-warning">Back</a>
            <button type="reset" class="btn btn-default">Reset</button>
            @isset($revisi)
            <button type="submit" class="btn btn-primary">Save</button>
            @endisset
        </div>
    </div>

    {!! Form::close() !!}
</div>
@endsection