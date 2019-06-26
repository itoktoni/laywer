@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">

    {!! Form::open(['route' => $form.'_barcode', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Create Barcode</h2>
        </header>
        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Product</label>
                    <div class="col-md-5 {{ $errors->has('product_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4 option" name="product">
                            <option value="">Select Product</option>
                            @foreach($product as $value)
                            <option @isset($data) {{ $value->product_id == $data->product_id ? 'selected="selected"' : '' }} @endisset value="{{ $value->product_id }}">{{ $value->product_name }} ( {{ $value->product_id }} )</option>
                            @endforeach
                        </select>
                    </div> 
                    <div>
                        @isset($create)
                        <button type="submit" class="btn btn-primary">Create Code</button>
                        @endisset
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="textareaDefault">Qty</label>
                    <div class="col-md-5">
                        <input type="text" name="qty" class="form-control" value="{{ isset($data) ? $data->qty : '' }}" id="">
                    </div>
                    <div>
                        @isset($data)
                        <a target="_blank" href="{!! route("{$form}_barcode", ["print" => $data->unic ]) !!}" class="btn btn-danger">Print Barcode
                        </a>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection