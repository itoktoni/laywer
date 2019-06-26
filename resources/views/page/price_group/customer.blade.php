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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('[name="_token"]').val()
        }
    });

    $('#search-form').on('submit', function(e) {

        var produk = $('select[name=produk]').val();
        var segmentasi = $('input[name=segmentasi]').val();
        var top = $('input[name=top]').val();
        var site = $('input[name=site]').val();

        if (produk == '') {

            new PNotify({
                title: 'Information Product !',
                text: 'Please Choose the Product to Show the Price Group !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }
        else if (segmentasi == '') {

            new PNotify({
                title: 'Information Customer !',
                text: 'Please Choose the Segment to Show the Price Group !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }

        else if (top == '') {

            new PNotify({
                title: 'Information TOP !',
                text: 'Please Choose the TOP to Show the Price Group !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }

        else if (site == '') {

            new PNotify({
                title: 'Information Site !',
                text: 'Please Choose the Site to Show the Price Group !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }

        oTable.draw();
        e.preventDefault();

    });

    $('#customer').change(function() {
        var id = $("#customer option:selected").val();
        var split = id.split("#");
        var customer = split[0];
        var segment = split[1];
        var top = split[2];
        var site = split[3];

        if (customer == '') {

            new PNotify({
                title: 'Information Customer !',
                text: 'Please Check Your Customer !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }
        else if (segment == '') {

            new PNotify({
                title: 'Segmentation is Empty !',
                text: 'Check Segment in Data Master !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }
        else if (top == '') {

            new PNotify({
                title: 'TOP is Empty !',
                text: 'Check TOP in Data Master !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }

        else if (site == '') {

            new PNotify({
                title: 'Site is Empty !',
                text: 'Check Site in Data Master !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }

        else {

            $('input[name=top]').val(top);
            $('input[name=segmentasi]').val(segment);
            $('input[name=customer_id]').val(customer);
            $('input[name=site]').val(site);
        }

    });

    var oTable = $('#datatable').DataTable({
        processing: true,
        dom: '<l<t>p><"pull-left"i>',
        serverSide: true,
        pagingType: "full_numbers",
        ajax: {
            url: '{!! route(Route::currentRouteName()) !!}',
            method: 'POST',
            data: function(d) {
                d.produk = $('select[name=produk]').val();
                d.segmentasi = $('input[name=segmentasi]').val();
                d.top = $('input[name=top]').val();
                d.site = $('input[name=site]').val();
            }
        },
        columns: [
            @foreach($fields as $key => $value)
                    {data: '{{ $key }}', name: '{{ $key }}', searchable: false, orderable: false},
            @endforeach
        ]
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

    $('#customer').select2({
        placeholder: 'Select an customer',
        minimumInputLength: 3,
        ajax: {
            url: '{{ route("customer") }}',
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

@endsection

@section('content')
<div class="row">
    <div class="panel-body">

        {!! Form::open(['id' => 'search-form', 'files' => true]) !!}

        <div class="panel col-lg-5" style="margin-top: 10px;">
            <select id="customer" name="customer" class="form-control">
            </select>
        </div>

        <div class="panel col-lg-7" style="margin-top: 10px;">
            <select id="produk" name="produk" class="form-control">
            </select>
        </div>
        
        <div class="clearfix"></div>
        
        <header class="panel-heading">
            <button type="submit" class="btn btn-primary col-lg-push-1 pull-right">Search</button>
            <h2 class="panel-title">Price Group Customer</h2>

            <input type="hidden" name="top">
            <input type="hidden" name="customer_id">
            <input type="hidden" name="segmentasi">
            <input type="hidden" name="site">

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

