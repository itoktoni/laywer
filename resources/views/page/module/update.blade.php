@extends('backend.'.config('website.backend').'.layouts.app')

@component('component.select2')
    
@endcomponent
@push('javascript')
<script>
$(function() {

     $('#filter').select2({
        placeholder: 'Select an Group Filter',
        ajax: {
            url: '{{ route("filter") }}',
            dataType: 'json',
            data: function(params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('#group_module').select2({
        placeholder: 'Select an Group Module',
        ajax: {
            url: '{{ route("group_module") }}',
            dataType: 'json',
            data: function(params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

});
</script>

@endpush

@section('content')
<div class="row">
    {!! Form::model($data, ['route'=>[$form.'_update', $data->$key],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Edit {{ ucfirst($template) }}</h2>
        </header>
        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                @include('page.'.$template.'.form')
                <hr>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Function </label>
                    <div class="col-md-10">
                        @for ($i = 0; $i < count($act); $i++)
                        <div class="col-md-3" style="padding:0px 5px;margin-left: 0px;margin-bottom: 5x;">
                           <div>
                                <label style="cursor: pointer;" for="{{ $act[$i]['code'] }}">
                                <input type="checkbox" {{ $act[$i]['status'] == true ? 'checked=""' : '' }} name="actions[]" id="{{ $act[$i]['code'] }}" value="{{ $act[$i]['code'] }}">
                                 {{ ucwords(str_replace('_',' ',$act[$i]['code'])) }}
                                </label>
                                <input type="hidden" name="act[]" value="{{ $act[$i]['code'] }}">
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-md-2 control-label">Filter List</label>
                    <div class="col-md-4">
                        <select class="form-control input-sm mb-md" multiple id="filter" name="filter[]">
                            @if(!empty($detail))
                            @if(count($detail) > 1)
                            @foreach($detail as $d)
                            <option selected="" value="{{ $d }}">{{ $d }}</option>
                            @endforeach
                            @else
                            <option selected="" value="{{ $detail }}">{{ $detail }}</option>
                            @endif
                            @endif
                        </select>
                    </div>

                    <label class="col-md-2 control-label">Group Module</label>
                    <div class="col-md-4">
                        <select class="form-control input-sm mb-md" multiple id="group_module" name="group[]">
                            @foreach($group as $g)
                            <option selected="" value="{{ $g->group_module_code }}">{{ $g->group_module_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @isset($update)
                <button type="submit" class="btn btn-primary">Save</button>
                @endisset
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>
@endsection