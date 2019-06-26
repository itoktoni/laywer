@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">

    {!! Form::open(['route' => $form.'_create', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Create {{ ucwords(str_replace('_',' ',$template)) }}</h2>
        </header>

        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                @include('page.'.$template.'.form')
            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @isset($create)
                <button type="submit" class="btn btn-primary">Save</button>
                @endisset
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>

@endsection