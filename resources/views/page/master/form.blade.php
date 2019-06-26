
<div class="form-group">
    <label class="col-md-2 control-label">Account Name</label>
    <div class="col-md-4 {{ $errors->has('account_name') ? 'has-error' : ''}}">
        {!! Form::text('account_name', null, ['class' => 'form-control']) !!}
    </div>

    <label class="col-md-2 control-label">Account Owner</label>
    <div class="col-md-4 {{ $errors->has('account_owner') ? 'has-error' : ''}}">
        {!! Form::text('account_owner', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Account Location</label>
    <div class="col-md-4 {{ $errors->has('account_location') ? 'has-error' : ''}}">
        {!! Form::text('account_location', null, ['class' => 'form-control']) !!}
    </div>

    <label class="col-md-2 control-label">Account Number</label>
    <div class="col-md-4 {{ $errors->has('account_number') ? 'has-error' : ''}}">
        {!! Form::text('account_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Type</label>
    <div class="col-md-4 {{ $errors->has('account_type') ? 'has-error' : ''}}">
        {{ Form::select('account_type', ['REKENING' => 'REKENING', 'CASH' => 'CASH'], null, ['id' => 'kurir','class'=> 'form-control']) }}
    </div>
</div>

