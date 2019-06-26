@extends('backend.'.config('website.backend').'.layouts.app')

@section('javascript')

<script>
    $(function() {

        $(document).on('click', '#d', function() {
            var id = $("#d").val();
            $('button[value="' + id + '"]').parents("tr").remove();
        });

        $('#option4').change(function() {
            var id = $("#option4 option:selected").val();
            var split = id.split("#");
            var product_id = split[0];
            var product_price = split[1];

            if (product_price == '') {

                new PNotify({
                    title: 'Information Price !',
                    text: 'Please Check Your Price Bahan !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }
            else {

                $('input[name=harga]').val(product_price);
                $('input[name=harga]').attr("placeholder", product_price).blur();
                $('input[name="qty"]').val("");
            }
        });

        $("#tambah").click(function() {

            var input_qty = $('input[name=qty]').val();
            var input_harga = $('input[name="harga"]').val();

            if (input_qty && input_harga) {


                var name = $('select[name="product"] option:selected').text();
                var hidden_qty = $('input[name=qty]').val();
                var hidden_harga = $('input[name=harga]').val();
                var produk = $('select[name="product"] option:selected').val();

                var split = produk.split("#");
                var product_id = split[0];
                var product_price = split[1];

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

                    var markup = "<tr><td data-title='ID Product'>" + product_id + "</td><td data-title='Product'>" + name + "</td><td data-title='Price' class='text-right col-lg-1'>" + input_harga + "</td><td data-title='Stock' class='text-right col-lg-1'>" + input_qty + "</td><td data-title='Action'><button id='d' value='" + product_id + "' type='button' class='btn btn-danger btn-xs btn-block'>Delete</button></td><input type='hidden' value=" + product_id + " name='produks[]'><input type='hidden' value=" + input_qty + " name='quantity[]'><input type='hidden' value=" + input_harga + " name='price[]'><input type='hidden' value=" + hidden_harga + " name='s_price[]'></tr>";
                    $("table tbody").append(markup);

                    name = null;
                    hidden_qty = null;
                    hidden_harga = null;
                    produk = null;
                    input_harga = null;
                    input_qty = null;

                    $('input[name="hidden_harga"]').val("");
                    $('input[name="hidden_product"]').val("");
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
    {!! Form::open(['route' => $form.'_'.$action, 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default" style="margin-bottom: 300px;">
        <header class="panel-heading">
            <h2 class="panel-title">Purcase Orders</h2>
        </header>

        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Delivery Date</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            {!! Form::text('purchase_delivery_date', null, ['class' => 'form-control datepicker', 'id' => 'datepicker']) !!}
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <label class="col-md-2 control-label" for="inputDefault">Supplier</label>
                    <div class="col-md-4 {{ $errors->has('supplier_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="" name="supplier_id">
                            <option value="">Select Supplier</option>
                            @foreach($supplier as $value)
                            <option @isset($data) {{ $value->supplier_id == $data->supplier_id ? 'selected="selected"' : '' }} @endisset value="{{ $value->supplier_id }}">{{ $value->supplier_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="textareaDefault">Notes</label>
                    <div class="col-md-4">
                        {!! Form::textarea('purchase_note', null, ['class' => 'form-control', 'rows' => '3']) !!}
                    </div>

                    <label class="col-md-2 control-label" for="inputDefault">Warehouse</label>
                    <div class="col-md-4 {{ $errors->has('warehouse_id') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="option3" name="warehouse_id">
                            <option value="">Select Warehouse</option>
                            @foreach($warehouse as $value)
                            <option @isset($data) {{ $value->warehouse_id == $data->warehouse_id ? 'selected="selected"' : '' }} @endisset value="{{ $value->warehouse_id }}">{{ $value->warehouse_name }}</option>
                            @endforeach
                        </select>
                    </div> 

                </div>

                <br>
                <a id="tambah" style="margin-top: -20px;margin-bottom: 10px; " class="btn btn-success pull-right">Add Order Detail</a>
                <hr>

                <div class="form-group">

                    <label class="col-md-2 control-label" for="inputDefault">Product</label>
                    <div class="col-md-6" style="margin-bottom: 10px;" >

                        <input type="hidden" name="hidden_product">
                        <input type="hidden" name="hidden_harga">

                        <div class="col-md-12 {{ $errors->has('product') ? 'has-error' : ''}}">
                            <select class="form-control col-md-4" id="option4" name="product">
                                <option value="">Select Product</option>
                                @foreach($product as $value)
                                <option value="{{ $value->product_id.'#'.$value->product_harga_beli }}">
                                    {{ $value->product_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group mb-md">
                            <span class="input-group-addon ">Rp</span>
                            <input class="form-control" name="harga" type="text">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group mb-md">
                            <span class="input-group-addon ">Yard</span>
                            <input class="form-control" id="datepicker" name="qty" type="text">
                        </div>
                    </div>

                </div>

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


