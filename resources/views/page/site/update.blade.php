@extends('backend.'.config('website.backend').'.layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/vendor/jquery-ui/css/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/vendor/select/select2.css') }}">
@endsection

@section('js')
<script src="{{ asset('public/assets/vendor/jquery-ui/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/select/select2.min.js') }}"></script>
@endsection

@section('javascript')

<script>

$(function () {
    $('#site').select2({
        placeholder: 'Select an site',
        ajax: {
            url: '{{ route("site_all") }}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
});
</script>

@endsection

@section('content')
<div class="row">
    {!! Form::model($data, ['route'=>[$form.'_update', $data->$key],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Edit {{ ucwords(str_replace('_',' ',$template)) }}</h2>
        </header>
        <div class="panel-body">

            <div class="col-md-12 col-lg-12">
                @include('page.'.$template.'.form')
                <hr>
                <div class="form-group">
                    <label class="col-md-2 control-label">Site List</label>
                    <div class="col-md-10">
                        <select class="form-control input-sm mb-md" multiple id="site" name="sites[]">
                            @foreach($site as $s)
                            <option selected="" value="{{ $s->site_id }}">{{ $s->site_name }}</option>
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