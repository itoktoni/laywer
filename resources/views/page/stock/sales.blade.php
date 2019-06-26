@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')

<script>

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('[name="_token"]').val()
            }
        });

        $('#search-form').on('submit', function(e) {

            oTable.draw();
            e.preventDefault();

        });

        var oTable = $('#datatable').DataTable({
            processing: true,
            dom: '<l<t>p><"pull-left"i>',
            serverSide: true,
            ajax: {
                url: '{!! route(Route::currentRouteName()) !!}',
                method: 'POST',
                data: function(d) {
                    d.code = $('select[name=code]').val();
                    d.aggregate = $('select[name=aggregate]').val();
                    d.search = $('input[name=search]').val();
                }
            },
            pagingType: "full_numbers",
            columns: [
            @foreach($fields as $key => $value)
            {data: '{{ $key }}', name: '{{ $key }}', searchable: false},
            @endforeach
            ]
        });
    });

</script>

<div class="row">
    <div class="panel-body">

        {!! Form::open(['id' => 'search-form', 'files' => true]) !!}

        <header class="panel-heading">
            <h2 class="panel-title">Stock Sales</h2>
        </header>

        <div class="form-inline panel">
            <select name="code" class="form-control">
                <option value="">Item Data</option>
                @foreach($fields as $item => $value)
                <option value="{{ $item }}">{{ $value }}</option>
                @endforeach
            </select>

            <select name="aggregate" class="form-control">
                <option value="">Aggregate</option>
                <option value="=">Equals</option>
                <option value="!=">Not Equals</option>
                <option value="like">Contains</option>
                <option value="not like">Not Contains</option>
                <option value=">">Greater Than</option>
                <option value="<">Less Than</option>
            </select>

            <div class="input-group col-lg-4">
                <input name="search" class="form-control" placeholder="Advance Search" type="text">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Search</button>
                </span>
            </div>

        </div>

        <div class="panel-body col-lg-12">
            <div class="form-group">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                @foreach($fields as $item => $value)
                                <th style="width: {{ $item == "product_name" ? "60%" : strlen($value) }}">{{ $value }}</th>
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </diV>
            </div>
        </div>

        {!! Form::close() !!}

    </div>
</div>

@endsection