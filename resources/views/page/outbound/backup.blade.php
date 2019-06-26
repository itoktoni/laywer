
@extends('backend.'.config('website.backend').'.layouts.popup')

@section('css')
<style>


.fa-close:before, .fa-remove:before, .fa-times:before{
    margin-top: -60px;
}

.ui-pnotify.notification-danger .notification, .ui-pnotify.notification-danger .notification-danger, .ui-pnotify .notification .ui-pnotify-icon{
    margin-top: -60px;
}

</style>

@endsection

@section('js')

@endsection

@section('javascript')

<script>
    $(function() {

        $(document).on('click', '#d', function() {
            var id = $("#d").val();
            $('button[value="' + id + '"]').parents("tr").remove();
        });

        $('#po').focus();

        $('#po').keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                $('#product').focus();

                $('#product').keypress(function(x) {
                    if(x.which == 13) {
                        x.preventDefault();
                        $('#barcode').focus();

                        $('#barcode').keypress(function(y) {
                            if(y.which == 13) {
                                y.preventDefault();

                                var product = $('#product').val();
                                var barcode = $('#barcode').val();

                                if(barcode.includes("#")){

                                    var split = barcode.split("#");
                                    var code = split[0];
                                    var id = split[1];
                                    var qty = split[2];

                                    if(qty.trim() == "undefined"){

                                        new PNotify({
                                            title: 'Qty Must Number2 !',
                                            text: 'Qty Must Number !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }

                                    else if (code == '' || code == 'undefined') {

                                        new PNotify({
                                            title: 'Barcode Error !',
                                            text: 'ID Product Empty !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }

                                    else if(id == '' || id == 'undefined'){

                                        new PNotify({
                                            title: 'Barcode Error !',
                                            text: 'ID Product Empty !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }

                                    else if(qty.trim() == ''){

                                        new PNotify({
                                            title: 'Barcode Error !',
                                            text: 'ID Product Empty !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }

                                    else if(product != id){

                                        new PNotify({
                                            title: 'Barcode Error !',
                                            text: 'Please Check Your ID Product !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }
                                    else{

                                        var ep = document.getElementsByName('barcode[]');
                                        for (i = 0; i < ep.length; i++) {
                                            if (ep[i].value.trim() == code.trim()) {

                                                new PNotify({
                                                    title: 'Barcode Already Exist',
                                                    text: 'Barcode ' + code.trim() + ' , Already in Table ',
                                                    addclass: 'notification-danger',
                                                    icon: 'fa fa-bolt'
                                                });

                                                return;
                                            }
                                        }

                                        var markup = "<tr><td data-title='Id Product'>" + id + "</td><td data-title='Quantity'>" + qty + "</td><td data-title='Action'><button id='d' value='" + id + "' type='button' class='btn btn-danger btn-xs btn-block'>Delete</button></td><input type='hidden' value=" + code + " name='barcode[]'><input type='hidden' value=" + id + " name='produk[]'></td><input type='hidden' value=" + qty + " name='qty[]'></tr>";
                                        $("table tbody").append(markup);

                                        // $('#po').val('');
                                        // $('#product').val('');
                                        $('#barcode').val('');
                                        $('#barcode').focus();

                                        $('#barcode').keypress(function(z) {
                                            if(z.which == 13) {
                                                z.preventDefault();
                                            }
                                        });

                                    }
                                }

                            }
                        });
                    }
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
            <h2 class="panel-title">Inbound</h2>
        </header>

        <div class="panel-body">
            <div class="col-xs-12 col-lg-12">

                <div class="form-group">
                    {!! Form::label($template.'_link', 'PO Number', ['class' => 'col-xs-4 control-label text-right']) !!}
                    <div class="col-xs-8 {{ $errors->has($template.'_po') ? 'has-error' : ''}}">
                        <input type="text" name="reference" class="form-control" id="po">
                    </div>

                    {!! Form::label($template.'_link', 'Product ID', ['class' => 'col-xs-4 control-label text-right']) !!}
                    <div class="col-xs-8 {{ $errors->has($template.'_product') ? 'has-error' : ''}}">
                        <input type="text" name="product_code" class="form-control" id="product">
                    </div>   
                </div>

                <hr>

                <div class="form-group">

                    <div class="col-xs-12 {{ $errors->has($template.'_barcode') ? 'has-error' : ''}}">
                        <input type="text" name="barcode" placeholder="PLEASE SCAN BARCODE HERE !" id="barcode" class="form-control">
                    </div>

                </div>

                <hr>

                <table class="table table-no-more table-bordered table-striped mb-none">
                    <thead>
                        <tr>
                            <th class="text-left col-lg-1">ID Product</th>
                            <th class="text-left">Qty</th>
                            <th class="text-center col-lg-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div class="form-group" style="position: fixed;bottom:55px;width: 100%; ">
                <div class=" {{ $errors->has($template.'_rack') ? 'has-error' : ''}}">
                    <input type="text" name="rack_code" placeholder="SCAN RACK FOR PLACE !!!" class="form-control" id="rack">
                </div>
            </div> 
        </div>
        
        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px;top:5px;margin-bottom: 5px; margin-top: 5px;">
              <button type="reset" class="btn btn-default col-md-1 col-xs-1">X</button>
              <a href="{!! route("{$form}_list") !!}" class="btn btn-warning col-xs-5 col-md-1" style="margin-right: 10px;margin-left: 10px;margin-bottom: 10px;">Back</a>
              @isset($create)
              <button type="submit" class="btn btn-primary col-xs-5 col-md-1 pull-right" style="margin-right: 5px;">Save</button>
              @endisset
          </div>
      </div>

      {!! Form::close() !!}
  </div>

  @endsection
