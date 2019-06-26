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
<script type="text/javascript">

$(function() {
    $("#multiple").select2({
        placeholder: 'Select Segmentasi'
    });
});

</script>

@endsection



@section('content')
<script>

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('[name="_token"]').val()
            }
        });

        $('#search-form').on('submit', function(e) {

            var produk = $('select[name=produk]').val();
            var segmentasi = $('select[name=segmentasi]').val();

            if (produk == '') {

                new PNotify({
                    title: 'Information Product !',
                    text: 'Please Choose the Product to Show the Price Group !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }
            if (segmentasi == '') {

                new PNotify({
                    title: 'Information Segmentasi !',
                    text: 'Please Choose the Segment to Show the Price Group !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }

            oTable.draw();
            e.preventDefault();
        });

        $('#produk').select2({
            placeholder: 'Select an item',
            minimumInputLength: 3,
            ajax: {
                url: '{{ route("produk_all") }}',
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

        var oTable = $('#datatable').DataTable({
            processing: true,
            dom: '<l<t>p><"pull-right"i>',
            serverSide: true,
            ajax: {
                url: '{!! route(Route::currentRouteName()) !!}',
                method: 'POST',
                data: function(d) {
                    d.produk = $('select[name=produk]').val();
                    d.segmentasi = $('select[name=segmentasi]').val();
                }
            },
            columns: [
                @foreach($fields as $key => $value)
                        {data: '{{ $key }}', name: '{{ $key }}', searchable: false, orderable: false},
                @endforeach
            ]
        });
    });

</script>

<div class="row">
    <div class="panel-body">

        {!! Form::open(['id' => 'search-form', 'files' => true]) !!}
        
        <div class="panel col-lg-3" style="margin-top: 10px;">
            <select name="segmentasi" id="multiple" class="form-control">
                <option value="">Select Segmentasi</option>
                @foreach($segment as $s)
                <option value="{{ $s->segmentasi_id }}">{{ $s->segmentasi_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="panel col-lg-9" style="margin-top: 10px;">
            <select id="produk" name="produk" class="form-control">
            </select>
        </div>
        
        <div class="clearfix"></div>
        
        <header class="panel-heading">
            <button type="submit" class="btn btn-primary col-lg-push-1 pull-right">Search</button>
            <h2 class="panel-title">Price Group Top</h2>
        </header>

        <div class="panel-body col-lg-12">
            <div class="form-group">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                @foreach($fields as $item => $value)
                                <th>{{ $value }}</th>
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