@extends('backend.'.config('website.backend').'.layouts.app')

@component('component.select2')    
@endcomponent

@push('javascript')
<script>

$(function () {
   
    $('#group').select2({
        placeholder: 'Select an group',
        ajax: {
            url: '{{ route("group_all") }}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('#team').select2({
        placeholder: 'Select an team',
        ajax: {
            url: '{{ route("team_all") }}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('#sales').select2({
        placeholder: 'Select an sales',
        ajax: {
            url: '{{ route("team_all") }}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
});
</script>

@endpush

@section('content')

<div class="row">
    {!! Form::model($model, ['route'=>[$form.'_update', 'code' => $model->$key],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel panel-default" style="margin-bottom: 300px;">
        <header class="panel-heading">
            <h2 class="panel-title">Edit Users</h2>
        </header>
        @include('page.'.$template.'.form')
        
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


