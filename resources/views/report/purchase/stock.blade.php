@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">

    {!! Form::open(['route' => $form.'_stock',  'method' => 'get', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Report Stock By Product</h2>
        </header>

        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
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
                    <label class="col-md-2 control-label">Product</label>
                   <div class="col-md-4 {{ $errors->has('customer_id') ? 'has-error' : ''}}">
                    <select class="form-control col-md-4 option" name="product">
                        <option value="">Select Product</option>
                        <option value="all">All Product</option>
                        @foreach($product as $value)
                        <option @isset($data) {{ $value->product_id == $data->product_name ? 'selected="selected"' : '' }} @endisset value="{{ $value->product_id }}">{{ $value->product_name }}</option>
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