<div class="form-group">
    <label class="col-md-2 control-label">Name</label>
    <div class="col-md-4 {{ $errors->has($template.'_name') ? 'has-error' : ''}}">
        {!! Form::text($template.'_name', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
    </div>
    <label class="col-md-2 control-label">Description</label>
    <div class="col-md-4 {{ $errors->has('category_description') ? 'has-error' : ''}}">
        {!! Form::textArea($template.'_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>
