@component('component.tinymce', ['array' => ['advance']])
@endcomponent

@component('component.select2')
@endcomponent

<div class="form-group">    
    <label class="col-md-2 control-label">Product Name</label>
    <div class="col-md-4 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

     <label class="col-md-2 control-label">Price</label>
    <div class="col-md-4 {{ $errors->has('price') ? 'has-error' : ''}} {{ $errors->has('price') ? 'has-error' : ''}}">
        {!! Form::number('price', null, ['class' => 'form-control', 'placeholder' => 'Harga Beli']) !!}
    </div>

</div>

<hr>

<div class="form-group">
   
    <label class="col-md-2 control-label">Product Active</label>
    <div class="col-md-4 {{ $errors->has('active') ? 'has-error' : ''}}">
        {{ Form::select('active', $status, null, ['class'=> 'form-control']) }}
    </div>
    
     <label class="col-md-2 control-label" for="inputDefault">Product Picture</label>
    <div class="col-md-4">
        {!! Form::file('images', ['class' => 'btn btn-default btn-sm btn-block']) !!}
    </div>
</div>


<hr>

<div class="form-group">
   
    <label class="col-md-2 control-label">Category</label>
    <div class="col-md-4 {{ $errors->has('category_id') ? 'has-error' : ''}}">
        {{ Form::select('category_id', $category, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
    </div>
    
    <label class="col-md-2 control-label" for="inputDefault">Tag</label>
    <div class="col-md-4 {{ $errors->has('tags') ? 'has-error' : ''}}">
        {{ Form::select('tags[]', $tag, null, ['class'=> 'form-control', 'multiple', 'data-plugin-selectTwo']) }}
    </div>
</div>

<input type="hidden" value="test" name="test">
<hr>

<div class="form-group">
    {!! Form::label('name', 'Product Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10 {{ $errors->has('description') ? 'has-error' : ''}}">
        {{ Form::textarea('description', null, ['class' => 'form-control advance', 'rows' => '15']) }}
    </div>  
</div>