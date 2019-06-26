@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">
    {!! Form::model($data, ['route'=>[$form.'_update', $data->$key],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">
                Edit {{ ucwords(str_replace('_',' ',$template)) }} Voucher : {{ $data->payment_voucher }}

            </h2>
            @isset($data)
            @if($data->payment_model != '')
            <hr>
            <h4 class="text-danger text-right"> 
                Sisa Total Tagihan {{ $data->reference }} : {{ number_format($tagihan + $delivery ) }}
                <input type="hidden" name="total_tagihan" value="{{$tagihan + $delivery}}">
            </h4>
            @endif
            @endisset
        </header>
        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                @include('page.'.$template.'.form')
            </div>
        </div>
    </div>

    <div class="navbar-fixed-bottom" id="menu_action">
        <div class="text-right" style="padding:5px">
            <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
            <button type="reset" class="btn btn-default">Reset</button>
            @isset($update)
            <button type="submit" class="btn btn-primary">Save</button>
            @endisset
        </div>
    </div>

    {!! Form::close() !!}
</div>
@endsection