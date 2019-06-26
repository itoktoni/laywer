@component('component.tinymce', ['array' => 'basic'])
    
@endcomponent
<div class="form-group">
    <label class="col-md-2 control-label">Name</label>
    <div class="col-md-10 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Icon</label>
    <div class="col-md-10 {{ $errors->has('icon') ? 'has-error' : ''}}">
        {!! Form::text('icon', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Link</label>
    <div class="col-md-10 {{ $errors->has('link') ? 'has-error' : ''}}">
        {!! Form::text('link', null, ['class' => 'form-control']) !!}
    </div>
</div>