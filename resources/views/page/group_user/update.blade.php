@extends('backend.'.config('website.backend').'.layouts.app')

@component('component.select2')
    
@endcomponent
@push('javascript')
<script>

$(function () {

    $('#filter').select2({
        placeholder: 'Select an filter',
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

    $('#group_module').select2({
        placeholder: 'Select an filter',
        ajax: {
            url: '{{ route("group_module") }}',
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
    {!! Form::model($data, ['route'=>[$form.'_update', $data->$key],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Edit {{ ucwords(str_replace('_',' ',$template)) }}</h2>
        </header>
        <div class="panel-body">

            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    {!! Form::label($template.'_code', 'Code', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4 {{ $errors->has($template.'_code') ? 'has-error' : ''}}">
                        {!! Form::text($template.'_code', null, ['class' => 'form-control']) !!}
                        {!! $errors->first($template.'_code', '<p class="help-block">:message</p>') !!}
                    </div>

                    {!! Form::label($template.'_name', 'Name', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4 {{ $errors->has($template.'_name') ? 'has-error' : ''}}">
                        {!! Form::text($template.'_name', null, ['class' => 'form-control']) !!}
                        {!! $errors->first($template.'_name', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"> User List</label>
                    <div class="col-md-10">
                        <select class="form-control input-sm mb-md" multiple id="filter" name="user_list[]">
                            @foreach($list_user as $g)
                            <option selected="" value="{{ $g->user_id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>

                <div class="form-group">
                    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-10">
                        {!! Form::textarea($template.'_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-md-2 control-label">Group Module</label>
                    <div class="col-md-10">
                        <select class="form-control input-sm mb-md" multiple id="group_module" name="group_module[]">
                            @foreach($list_group_module as $d)
                            <option selected="" value="{{ $d->group_module_code }}">{{ $d->group_module_name }}</option>
                            @endforeach
                        </select>
                    </div>
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


    </div>
    {!! Form::close() !!}
</div>
@endsection