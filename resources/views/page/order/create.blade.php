@extends('backend.'.config('website.backend').'.layouts.app')

@section('javascript')

<script>
    $(function() {

        $(document).on('click', '#d', function() {
            var id = $("#d").val();
            $('button[value="' + id + '"]').parents("tr").remove();
        });

        $('#customer').change(function() {
            var id = $("#customer option:selected").val();
            var split = id.split("#");
            var customer = split[0];
            var address = split[1];
            var province = split[2];
            var city = split[3];

            if (address == '') {

                new PNotify({
                    title: 'Address Not Set !',
                    text: 'Master Customer Address Is Empty !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }
            else {

                $('input[name=customer_id]').val(customer);
                $('#address').val(address);

                var drop_city = $('#city_from');
                var drop_province = $('#province_from');
                
                var drop_province_tujuan = $('#province');
                var drop_city_tujuan = $('#city');

                $.ajax({
                   type: 'POST',
                   headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route("city") }}',
                    data: 'id='+city,
                    dataType: 'JSON',
                    success: function(data){
                        $.each(data, function (key, val) {
                            // drop_city.append('<option value="' + val.id + '">' + val.text + '</option>');
                            drop_city_tujuan.append('<option value="' + val.id + '">' + val.text + '</option>');
                        })                  
                    }
                });

                $.ajax({
                   type: 'POST',
                   headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route("province") }}',
                    data: 'id='+province,
                    dataType: 'JSON',
                    success: function(data){
                        $.each(data, function (key, val) {
                            // drop_province.val(val.id).trigger('change');
                            // drop_province.val(val.id);
                            drop_province_tujuan.val(val.id).trigger('change');
                            drop_province_tujuan.val(val.id);
                        })                  
                    }
                });    
            }
        });

        $('#province_from').change(function() {
            var id = $("#province_from option:selected").val();

            $('#city_from').select2({
                placeholder: 'Select an City',
                ajax: {
                    url: '{{ route("city") }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                        q: params.term, // search term
                        province: id,
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

        $('#province').change(function() {
            var id = $("#province option:selected").val();

            $('#city').select2({
                placeholder: 'Select an City',
                ajax: {
                        url: '{{ route("city") }}',
                        dataType: 'json',
                        data: function (params) {
                            return {
                            q: params.term, // search term
                            province: id,
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

         $('#material').change(function() {
            var id = $("#material option:selected").val();
            
            $('#product').select2({
                ajax: {
                    url: '{{ route("product_segmentasi") }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            material: id
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

        $('#product').change(function() {
            var id = $("#product option:selected").val();
            var material = $("#material option:selected").val();
            
            $('#size').select2({
                ajax: {
                    url: '{{ route("produk_all") }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            segmentasi: id,
                            material: material
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


        $('#kurir').change(function() {
            var kurir = $("#kurir option:selected").val();
            var weight = $("#gram").val();
            var from = $("#city_from").val();
            var to = $("#city").val();
            var service = $("#service");

            if (weight == '') {
                new PNotify({
                    title: 'Weight is Empty !',
                    text: 'Please Input correct Weight !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }
            else{
                $.ajax({
                   type: 'POST',
                   headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("ongkir") }}',
                data: {from: from, to: to, weight: weight, courier:kurir},
                dataType: 'JSON',
                success: function(data){
                    service.empty();
                    service.append('<option value="">Please Select service</option>');
                    $.each(data, function (key, val) {
                        service.append('<option value="' + val.id + '">' + val.text + '</option>');
                    })                  
                }
            });

            }
        });

        $('#service').change(function() {
            var harga = $("#service option:selected").val();
            var estimasi = $("#estimasi");
            var courier = $('input[name=courier_service]');

            var split = harga.split("#");
            var price = split[0];
            var service = split[1];

            estimasi.val(price);
            courier.val(service);
        });

        $('#size').change(function() {
            var id = $("#size option:selected").val();
            var split = id.split("#");
            var product = split[0];
            var price = split[1];
            var stock = split[2];
            var name = split[3];
            var weight = split[4];

            if (stock == '') {

                new PNotify({
                    title: 'Stock is Empty !',
                    text: 'You Can Continue with input the stock Manualy !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }
            else {

                $('input[name=qty]').val(stock);
                $('input[name=harga]').val(price);
                $('input[name=product_id]').val(product);
                $('input[name=product_name]').val(name);
                $('input[name=product_weight]').val(weight);
            }
        });

        $("#tambah").click(function() {

            var qty = $('input[name=qty]').val();
            var harga = $('input[name="harga"]').val();
            var id = $('input[name="product_id"]').val();
            var name = $('input[name="product_name"]').val();
            var weight = $('input[name="product_weight"]').val();

            if (qty && harga) {

                var produk = $("#size option:selected").val();

                var split = produk.split("#");
                var product_id = split[0];
                var hidden_harga = split[1];
                var stock = split[2];
                var name = split[3];
                var weight = split[4];

                if (name) {
                    var ep = document.getElementsByName('produks[]');
                    for (i = 0; i < ep.length; i++) {
                        if (ep[i].value.trim() == product_id.trim()) {

                            new PNotify({
                                title: 'Product Already Exist',
                                text: 'Product ' + name.trim() + ' , Already in Table ',
                                addclass: 'notification-danger',
                                icon: 'fa fa-bolt'
                            });

                            return;
                        }
                    }

                    var markup = "<tr><td data-title='ID Product'>" + product_id + "</td><td data-title='Product'>" + name + "</td><td data-title='Price' class='text-right col-lg-1'>" + harga + "</td><td data-title='Stock' class='text-right col-lg-1'>" + qty + "</td><td data-title='Action'><button id='d' value='" + product_id + "' type='button' class='btn btn-danger btn-xs btn-block'>Delete</button></td><input type='hidden' value=" + product_id + " name='produks[]'><input type='hidden' value=" + qty + " name='quantity[]'><input type='hidden' value=" + harga + " name='price[]'><input type='hidden' value=" + hidden_harga + " name='s_price[]'></tr>";
                    $("table tbody").append(markup);

                    var sub_total = parseInt(weight) * parseFloat(qty); 
                    var total = $('#gram').val();
                    $('#gram').val('');
                    if(total == ''){
                        total = parseInt(sub_total);  
                    }
                    else{
                        total = parseInt(total) + parseInt(sub_total);
                    }           

                    $('#gram').val(parseInt(total));

                    name = null;
                    hidden_harga = null;
                    produk = null;
                    harga = null;
                    qty = null;

                    $('input[name="product_name"]').val("");
                    $('input[name="product_id"]').val("");
                    $('input[name="harga"]').val("");
                    $('input[name="qty"]').val("");

                    $('input[name=harga]').attr("placeholder", "").blur();
                    $('input[name=qty]').attr("placeholder", "").blur();
                }
                else {

                    new PNotify({
                        title: 'Choose Product',
                        text: 'Please Select Product !',
                        addclass: 'notification-danger',
                        icon: 'fa fa-bolt'
                    });
                }
            }
            else {
                new PNotify({
                    title: 'Price and Quantity',
                    text: 'Please Input Price & Quantity !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }
        });

    });
</script>
@endsection

@section('content')

<div class="row">
    {!! Form::open(['route' => $form.'_create', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default" style="margin-bottom: 300px;">
        <header class="panel-heading">
            <h2 class="panel-title">Sales Orders</h2>
        </header>

        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Customer</label>
                    <div class="col-md-4 {{ $errors->has('user_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4 option" id="customer" name="">
                            <option value="">Select Customer</option>
                            @foreach($customer as $value)
                            <option @isset($data) {{ $value->customer_id == $data->customer_id ? 'selected="selected"' : '' }} @endisset value="{{ $value->customer_id.'#'.$value->customer_address.'#'.$value->province_id.'#'.$value->city_id }}">{{ $value->customer_name }}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="customer_id">
                    </div>
                    <label class="col-md-2 control-label" for="inputDefault">Delivery Date</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            {!! Form::text('order_delivery_date', null, ['class' => 'form-control datepicker']) !!}
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-md-2 control-label">Notes</label>
                    <div class="col-md-4 {{ $errors->has('order_note') ? 'has-error' : ''}}">
                        {!! Form::textarea('order_note', null, ['class' => 'form-control', 'rows' => '2']) !!}
                    </div>

                   <label class="col-md-2 control-label" for="inputDefault">Material</label>
                    <div class="col-md-4 {{ $errors->has('material_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4 option" id="material" name="material">
                            <option value="">Select Material</option>
                            @foreach($bahan as $value)
                            <option {{ $value->material_id }} value="{{ $value->material_id }}">{{ $value->material_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>

                <div class="form-group form-inline">
                    <div class="input-group col-md-4">
                        <label class="input-group-addon" for="inputDefault">Product</label>
                        <select class="form-control option2" id="product" name="segmentasi">
                            <option value="">Silahkan Pilih Product</option>
                            @foreach($segmentasi as $value)
                            <option value="{{ $value->segmentasi_id }}">
                                {{ $value->segmentasi_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group col-md-2">
                        <label class="input-group-addon" for="inputDefault">Size</label>
                        <select class="form-control option3" id="size" name="produk">
                        </select>
                        <input type="hidden" name="product_id">
                        <input type="hidden" name="product_name">
                        <input type="hidden" name="product_weight">
                    </div>

                    <div class="input-group col-md-2">
                        <span class="input-group-addon ">Rp</span>
                        <input class="form-control" {{ Auth::user()->group_user != 'developer' ? 'readonly=""' : '' }} name="harga" type="text">
                    </div>

                    <div class="input-group col-md-2">
                        <span class="input-group-addon ">Qty</span>
                        <input class="form-control" id="qty" name="qty" type="text">
                    </div>

                    <div class="input-group">
                        <a id="tambah" class="btn btn-success">Add Order Detail</a>
                    </div>
                </div>

                <div class="form-group">
                    <table class="table table-no-more table-bordered table-striped mb-none">
                        <thead>
                            <tr>
                                <th class="text-left col-lg-1">ID Product</th>
                                <th class="text-left">Product Name</th>
                                <th class="text-right col-lg-1">Price</th>
                                <th class="text-right col-lg-1">QTY</th>
                                <th class="text-center col-lg-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>    
            </div>
        </div>
        <header class="panel-heading">
            <h2 class="panel-title">Pengiriman</h2>
        </header>
        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label">Provinsi Pengirim</label>
                    <div class="col-md-4 {{ $errors->has('province_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="province_from" name="province_from">
                            <option value="{{ $city['province_id'] }}">{{ $city['province'] }}</option>
                        </select>
                    </div>
                    <label class="col-md-2 control-label">Kota Pengirim</label>
                    <div class="col-md-4 {{ $errors->has('city_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="city_from" name="city_from">
                            <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Provinsi Tujuan</label>
                    <div class="col-md-4 {{ $errors->has('province_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4 option" id="province" name="province_id">
                            <option value="">Select Province</option>
                            @isset($province)
                            @foreach($province as $value)
                            <option @isset($data) {{ $value['province_id'] == $data->province_id ? 'selected="selected"' : '' }} @endisset value="{{ $value['province_id'] }}">{{ $value['province'] }}</option>
                            @endforeach
                            @endisset
                        </select>
                    </div>
                    <label class="col-md-2 control-label">Kota Tujuan</label>
                    <div class="col-md-4 {{ $errors->has('city_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="city" name="city_id">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label" for="textareaDefault">Address</label>
                    <div class="col-md-10">
                        {!! Form::textarea('order_address', null, ['id' => 'address', 'class' => 'form-control', 'rows' => '2']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Pengiriman</label>
                    <div class="col-md-4 block {{ $errors->has('qty_total') ? 'has-error' : ''}}">
                        <div class="input-group">
                            {!! Form::text('qty_total', null, ['id' => 'gram','class' => 'form-control','readonly=readonly']) !!}
                            <span class="input-group-addon">
                                g
                            </span>
                        </div>
                    </div>

                    <label class="col-md-2 control-label">Jasa Kurir</label>
                    <div class="col-md-4 {{ $errors->has('courier') ? 'has-error' : ''}}">
                        {{ Form::select('courier', ['' => 'Pilih Paket',
                        'pos' => 'POS Indonesia (POS)', 
                        'jne' => 'Jalur Nugraha Ekakurir (JNE)',
                        'tiki' => 'Citra Van Titipan Kilat (TIKI)', 
                        'pcp' => 'Priority Cargo and Package (PCP)',
                        'esl' => 'Eka Sari Lorena (ESL)',
                        'rpx' => 'RPX Holding (RPX)',
                        'pandu' => 'Pandu Logistics (PANDU)',
                        'wahana' => 'Wahana Prestasi Logistik (WAHANA)',
                        'sicepat' => 'SiCepat Express (SICEPAT)',
                        'jnt' => 'J&T Express (J&T)',
                        'pahala' => 'Pahala Kencana Express (PAHALA)',
                        'cahaya' => 'Cahaya Logistik (CAHAYA)',
                        'sap' => 'SAP Express (SAP)',
                        'jet' => 'JET Express (JET)',
                        'jet' => 'JET Express (JET)',
                        'indah' => 'Indah Logistic (INDAH)',
                        'slis' => 'Solusi Ekspres (SLIS)',
                        'dse' => '21 Express (DSE)',
                        'dse' => '21 Express (DSE)',
                        'first' => 'First Logistics (FIRST)',
                        'ncs' => 'Nusantara Card Semesta (NCS)',
                        'star' => 'Star Cargo (STAR)',
                        ], null, ['id' => 'kurir','class'=> 'form-control option3']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="textareaDefault">Jenis Paket</label>
                    <div class="col-md-4 {{ $errors->has('courier_service') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="service" name="service">
                        </select>
                        <input type="hidden" id="courier_service" name="courier_service">
                    </div>
                    <label class="col-md-2 control-label" for="textareaDefault">Estimasi Pengiriman</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            {!! Form::text('estimasi_cost', null, ['id' => 'estimasi','class' => 'form-control', 'readonly' => 'readonly']) !!}
                            <span class="input-group-addon">
                                Rp
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                <button type="reset" class="btn btn-default">Reset</button>
                @isset($create)
                <button type="submit" class="btn btn-primary">Save</button>
                @endisset
            </div>
        </div>

        {!! Form::close() !!}
    </div>

    @endsection