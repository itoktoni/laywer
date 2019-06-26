@component('component.tinymce', ['array' => 'basic'])
    
@endcomponent
<div class="form-group">
    <label class="col-md-2 control-label">Name</label>
    <div class="col-md-10 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Price</label>
    <div class="col-md-10 {{ $errors->has('price') ? 'has-error' : ''}}">
        {!! Form::text('price', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Description</label>
    <div class="col-md-10 {{ $errors->has('description') ? 'has-error' : ''}}">
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
    </div>
</div>