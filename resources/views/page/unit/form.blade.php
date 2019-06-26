
<div class="form-group">
    <label class="col-md-2 control-label"> {{ Helper::label('unit_id') }}</label>
    <div class="col-md-4 {{ $errors->has('unit_id') ? 'has-error' : ''}}">
        {!! Form::text('unit_id', null, ['class' => 'form-control']) !!}
    </div>

    <label class="col-md-2 control-label">{{ Helper::label('unit_name') }}</label>
    <div class="col-md-4 {{ $errors->has('unit_name') ? 'has-error' : ''}}">
        {!! Form::text('unit_name', null, ['class' => 'form-control']) !!}
    </div>
</div>
