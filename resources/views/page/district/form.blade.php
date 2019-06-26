
<div class="form-group">
    <label class="col-md-2 control-label">
        {{ Helper::label('districts','subdistrict_name') }}
    </label>
    <div class="col-md-4 {{ $errors->has('subdistrict_name') ? 'has-error' : ''}}">
        {!! Form::text('subdistrict_name', null, ['class' => 'form-control']) !!}
    </div>
</div>