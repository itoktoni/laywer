@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/vendor/jquery-ui/css/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/vendor/select/select2.css') }}">
@endsection

@section('js')
<script src="{{ asset('public/assets/vendor/jquery-ui/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/select/select2.min.js') }}"></script>
@endsection

@section('javascript')

<script>

$(function() {
    $('#site').select2({
        placeholder: 'Select an filter',
    });
});
</script>

@endsection

<div class="form-group">
    {!! Form::label($template.'_id', 'Code', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($template.'_id') ? 'has-error' : ''}}">
        {!! Form::text($template.'_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first($template.'_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label($template.'_name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($template.'_name') ? 'has-error' : ''}}">
        {!! Form::text($template.'_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($template.'_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label($template.'_contact_person', 'Contact Person', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($template.'_contact_person') ? 'has-error' : ''}}">
        {!! Form::text($template.'_contact_person', null, ['class' => 'form-control']) !!}
        {!! $errors->first($template.'_contact_person', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label($template.'_contact_number', 'Contact Number', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($template.'_contact_number') ? 'has-error' : ''}}">
        {!! Form::text($template.'_contact_number', null, ['class' => 'form-control']) !!}
        {!! $errors->first($template.'_contact_number', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label($template.'_account_number', 'Account Number', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($template.'_account_number') ? 'has-error' : ''}}">
        {!! Form::number($template.'_account_number', null, ['class' => 'form-control']) !!}
        {!! $errors->first($template.'_account_number', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label($template.'_account_reference', 'Account Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($template.'_account_reference') ? 'has-error' : ''}}">
        {!! Form::text($template.'_account_reference', null, ['class' => 'form-control']) !!}
        {!! $errors->first($template.'_account_reference', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Address', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($template.'_address', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>




