
@extends('backend.'.config('website.backend').'.layouts.popup')
@section('css')
<style>
.panel-default>.panel-heading{
    margin-top: -40px;
}
@media screen and (max-width: 400px) and (min-width: 320px) {

    .ui-pnotify .notification-danger{
        margin-top: -60px;
    }
    .ui-pnotify.notification-danger .notification, .ui-pnotify.notification-danger .notification-danger, .ui-pnotify .notification .ui-pnotify-icon{
        margin-top: -60px;
    }
    .panel-default>.panel-heading{
        margin-top: 0px;
    }
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
                        $('#code').focus();
                        $('#code').keypress(function(y) {
                            if(y.which == 13) {
                                y.preventDefault();

                                var product = $('#product').val();
                                var barcode = $('#code').val();
                                
                                if(barcode.includes("#")){
                                    var split = barcode.split("#");
                                    var code = split[0];
                                    var id = split[1];
                                    var qty = split[2];

                                    if(qty.trim() == "undefined"){

                                        $('#code').val('');
                                        $('#code').focus();

                                        new PNotify({
                                            title: 'Qty Must Number2 !',
                                            text: 'Qty Must Number !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }

                                    else if (code == '' || code == 'undefined') {

                                        $('#code').val('');
                                        $('#code').focus();

                                        new PNotify({
                                            title: 'Barcode Error !',
                                            text: 'ID Product Empty !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }

                                    else if(id == '' || id == 'undefined'){

                                        $('#code').val('');
                                        $('#code').focus();

                                        new PNotify({
                                            title: 'Barcode Error !',
                                            text: 'ID Product Empty !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }

                                    else if(qty.trim() == ''){

                                        $('#code').val('');
                                        $('#code').focus();

                                        new PNotify({
                                            title: 'Barcode Error !',
                                            text: 'ID Product Empty !',
                                            addclass: 'notification-danger',
                                            icon: 'fa fa-bolt'
                                        });
                                    }

                                    else{

                                        $('#qty').val(qty);
                                        $('#barcode').val(code);
                                        $('#code').val('');
                                        $('#barcode').focus();
                                        if(qty != ''){

                                            $('#form').submit();    
                                        }
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

    {!! Form::open(['route' => $form.'_outbound_spk', 'id' => 'form', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default" style="margin-bottom: 300px;">
        <header class="panel-heading">
            <h2 class="panel-title">Outbound SPK</h2>
        </header>

        <div class="panel-body">
            <div class="col-xs-12 col-lg-12">

                <div class="form-group">
                    {!! Form::label($template.'_link', 'Reference', ['class' => 'col-xs-4 col-md-2 control-label text-right']) !!}
                    <div class="col-xs-8 col-md-4 {{ $errors->has($template.'_po') ? 'has-error' : ''}}">
                        <input type="text" name="reference" class="form-control" id="po">
                    </div>

                    {!! Form::label($template.'_link', 'Product ID', ['class' => 'col-xs-4 col-md-2 control-label text-right']) !!}
                    <div class="col-xs-8 col-md-4 {{ $errors->has($template.'_product') ? 'has-error' : ''}}">
                        <input type="text" name="product_code" class="form-control" id="product">
                        <input type="hidden" id="product_id" name="product_id">
                    </div>   
                </div>

                <hr>

                <div class="form-group">

                    <div class="col-xs-12 {{ $errors->has($template.'_barcode') ? 'has-error' : ''}}">
                        <input type="text" name="code" placeholder="PLEASE SCAN BARCODE HERE !" id="code" class="form-control">
                    </div>

                </div>

                <hr>

                <div class="form-group">
                    {!! Form::label($template.'_barcode', 'Barcode', ['class' => 'col-xs-4 col-md-2 control-label text-right']) !!}
                    <div class="col-xs-8 col-md-4">
                        <input type="text" readonly="" name="barcode" class="form-control" id="barcode">
                    </div>

                    {!! Form::label($template.'_link', 'Quantity', ['class' => 'col-xs-4 col-md-2 control-label text-right']) !!}
                    <div class="col-xs-8 col-md-4 {{ $errors->has('qty') ? 'has-error' : ''}}">
                        <input type="text" readonly="" name="qty" class="form-control" id="qty">
                    </div>   
                </div>
                <hr>
            </div>
        </div>
        
        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px;top:5px;margin-bottom: 5px; margin-top: 5px;">
              <button type="reset" class="btn btn-default col-md-1 col-xs-1">X</button>
              <a href="{!! route("stock_warehouse_real") !!}" class="btn btn-warning col-xs-5 col-md-1" style="margin-right: 10px;margin-left: 10px;margin-bottom: 10px;">Back</a>
              @isset($create)
              <button type="submit" class="btn btn-primary col-xs-5 col-md-1 pull-right" style="margin-right: 5px;">Save</button>
              @endisset
          </div>
      </div>

      {!! Form::close() !!}
  </div>

  @endsection
