
<div class="form-group">
    <label class="col-md-2 control-label">
        {{ Helper::label($table,'name') }}
    </label>
    <div class="col-md-4 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::text('province', null, ['class' => 'form-control']) !!}
    </div>
</div>