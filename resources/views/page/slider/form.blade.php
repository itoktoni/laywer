@component('component.tinymce', ['array' => 'basic'])
    
@endcomponent
<div class="form-group">
    <label class="col-md-2 control-label">Slider Name</label>
    <div class="col-md-10 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">Highlight</label>
    <div class="col-md-10 {{ $errors->has('highlight') ? 'has-error' : ''}}">
        {!! Form::text('highlight', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    
    <label class="col-md-2 control-label" for="inputDefault">Attachment</label>
    <div class="col-md-4">
        {!! Form::file('images', ['class' => 'btn btn-default btn-sm btn-block']) !!}
    </div>

    {!! Form::label('name', 'Type', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('type') ? 'has-error' : ''}}">
        {{ Form::select('type', $option, null, ['placeholder' => 'Please Select Type', 'class' => 'form-control']) }}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Slider Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('description') ? 'has-error' : ''}}">
        {!! Form::textarea('description', null, ['class' => 'form-control basic', 'rows' => '10']) !!}
    </div>
</div>

