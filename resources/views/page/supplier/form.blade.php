<div class="form-group">
    <label class="col-md-2 control-label">Supplier Name</label>
    <div class="col-md-4 {{ $errors->has('supplier_name') ? 'has-error' : ''}}">
        {!! Form::text('supplier_name', null, ['class' => 'form-control']) !!}
    </div>

    <label class="col-md-2 control-label">Contact Person</label>
    <div class="col-md-4 {{ $errors->has('email') ? 'has-error' : ''}}">
        <select class="form-control col-md-4 option" name="supplier_contact">
            <option value="">Select User</option>
            @foreach($user as $value)
            <option @isset($data) {{ $value->email == $data->supplier_contact ? 'selected="selected"' : '' }} @endisset value="{{ $value->email }}">{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Supplier Telp</label>
    <div class="col-md-4 {{ $errors->has('supplier_telp') ? 'has-error' : ''}}">
        {!! Form::text('supplier_telp', null, ['class' => 'form-control']) !!}
    </div>

    <label class="col-md-2 control-label" for="inputDefault">Attachment</label>
    <div class="col-md-4">
        {!! Form::file('files', ['class' => 'btn btn-default btn-sm btn-block']) !!}
    </div>
</div>

<div class="form-group">
   
    {!! Form::label('name', 'Supplier Alamat', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('supplier_alamat') ? 'has-error' : ''}}">
        {!! Form::textarea('supplier_alamat', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

    {!! Form::label('name', 'Supplier Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('supplier_description') ? 'has-error' : ''}}">
        {!! Form::textarea('supplier_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>

<div class="form-group">
   
    {!! Form::label('name', 'Supplier Bank', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('supplier_bank_name') ? 'has-error' : ''}}">
        {!! Form::textarea('supplier_bank_name', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

    {!! Form::label('name', 'Bank KCP', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('supplier_bank_place') ? 'has-error' : ''}}">
        {!! Form::textarea('supplier_bank_place', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

</div>

<div class="form-group">
   
    {!! Form::label('name', 'Bank Account', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('supplier_bank_account') ? 'has-error' : ''}}">
        {!! Form::textarea('supplier_bank_account', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

    {!! Form::label('name', 'Bank Person', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('supplier_bank_person') ? 'has-error' : ''}}">
        {!! Form::textarea('supplier_bank_person', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>

<div class="form-group">

     {!! Form::label('name', 'Supplier Owner', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('supplier_owner') ? 'has-error' : ''}}">
        {!! Form::text('supplier_owner', null, ['class' => 'form-control', 'placeholder' => 'Input Nama Owner, jika DO Supplier dicetak maka nama ini akan muncul']) !!}
    </div>
    
    {!! Form::label('name', 'Email', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('email') ? 'has-error' : ''}}">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>

</div>
