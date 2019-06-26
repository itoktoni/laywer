@extends('backend.'.config('website.backend').'.layouts.app')
@section('javascript')

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
});
</script>

@endsection

@section('content')

<div class="row">
    {!! Form::open(['route' => $form.'_create', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default" style="margin-bottom: 300px;">
        <header class="panel-heading">
            <h2 class="panel-title">Create Users</h2>
        </header>

        <div class="panel-body">
            <div class="col-md-12">
                <div class="form-group">                                          
                    <label class="col-md-2 control-label">NIK</label>
                    <div class="col-md-4 {{ $errors->has('nik') ? 'has-error' : ''}}">
                        {!! Form::text('nik', null,['class' => 'form-control']) !!}
                        {!! $errors->first('nik', '<p class="help-block">:message</p>') !!}
                    </div>

                    <label class="col-md-2 control-label">NPWP</label>
                    <div class="col-md-4">
                        {!! Form::text('no_tax', null,['class' => 'form-control']) !!}
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-4 {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    </div>

                    <label class="col-md-2 control-label">Email</label>
                    <div class="col-md-4 {{ $errors->has('email') ? 'has-error' : ''}}">
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Username</label>
                    <div class="col-md-4 {{ $errors->has('username') ? 'has-error' : ''}}">
                        {!! Form::text('username', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
                    </div>

                    <label class="col-md-2 control-label">Password</label>
                    <div class="col-md-4 {{ $errors->has('password') ? 'has-error' : ''}}">
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group">
                   
                    <label class="col-md-2 control-label">Group</label>
                    <div class="col-md-4">
                        <select class="form-control" id="option2" name="group_user">
                            @foreach($group as $d)
                            <option value="{{ $d->group_user_code }}">{{ $d->group_user_name }}</option>
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
                @isset($create)
                <button type="submit" class="btn btn-primary">Save</button>
                @endisset
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection


