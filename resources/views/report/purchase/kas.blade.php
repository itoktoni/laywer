@extends('backend.'.config('website.backend').'.layouts.app')

@section('javascript')
<script>
    $(function() {

        $('#model').change(function() {
            var id = $("#model option:selected").val();
            var url = '';
            if(id == 'PO'){
                url = '{{ route("po") }}';
            }
            else if(id == 'SO'){
                url = '{{ route("so") }}';
            }
            else if(id == 'SPK'){
                url = '{{ route("spk") }}';
            }
            else if(id == 'FEE'){
                url = '{{ route("fee") }}';
            }
            else if(id == 'DO'){
                url = '{{ route("do") }}';
            }
            else if(id == 'ETC'){
                url = '';
            }
            else{
                url = '';
                $('#reference').empty();
            }

            if(url != ''){
                $('#reference').select2({
                    placeholder: 'Select an Reference',
                    ajax: {
                        url: url,
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
            }
            else{
                $('#reference').select2({
                    placeholder: 'Select an Reference',
                });
            }
        });
    });
</script>
@endsection

@section('content')
<div class="row">

    {!! Form::open(['route' => $form.'_kas',  'method' => 'get', 'class' => 'form-horizontal', 'files' => true]) !!}  
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">Report Kas</h2>
        </header>

        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label">Tanggal Mulai</label>
                    <div class="col-md-4 {{ $errors->has('date_start') ? 'has-error' : ''}}">
                        <div class="input-group">
                            {!! Form::text('date_start', null, ['class' => 'form-control datepicker']) !!}
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <label class="col-md-2 control-label">Tanggal Akhir</label>
                    <div class="col-md-4 {{ $errors->has('tanggal_end') ? 'has-error' : ''}}">
                        <div class="input-group">
                            {!! Form::text('date_end', null, ['class' => 'form-control datepicker']) !!}
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-md-2 control-label">Bank Pengirim</label>
                    <div class="col-md-4 {{ $errors->has('product_category') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="option" name="pengirim">
                            <option value="">Select Account</option>
                            @foreach($from as $value)
                            <option value="{{ $value->account_from }}">{{ $value->account_from }}</option>
                            @endforeach
                            <option value="etc">Other Bank</option>
                        </select>
                    </div>

                    <label class="col-md-2 control-label">Bank Penerima</label>
                    <div class="col-md-4 {{ $errors->has('product_category') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="option2" name="penerima">
                            <option value="">Select Account</option>
                            @foreach($to as $value)
                            <option value="{{ $value->account_to }}">{{ $value->account_to }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Model Reference</label>
                    <div class="col-md-4 {{ $errors->has('payment_model') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="model" name="model">
                            @isset($data)
                            <option value="{{ $data->payment_model }}">{{ $model }}</option>
                            @else
                            <option value="">Select Model Reference</option>
                            @foreach($model as $key => $value)
                            <option @isset($data) {{ $key == $data->payment_model ? 'selected="selected"' : '' }} @endisset value="{{ $key }}">
                                {{ $value }}
                            </option>
                            @endforeach
                            @endisset
                        </select>
                    </div>
                    <label class="col-md-2 control-label">Reference Transaksi</label>
                    <div class="col-md-4 {{ $errors->has('reference') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="reference" name="reference">
                            @isset($data)
                            <option value="{{ $data->reference }}">{{ $data->reference }}</option>
                            @endisset
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Tipe Pembayaran</label>
                    <div class="col-md-4 {{ $errors->has('type') ? 'has-error' : ''}}">
                        {{ Form::select('type', ['' => 'Please Type Pembayaran', 'PENDING' => 'Pending','IN' => 'Uang Masuk', 'OUT' => 'Uang Keluar'], null, ['class'=> 'form-control']) }}
                    </div>
                    
                    <label class="col-md-2 control-label">Payment Status</label>
                    <div class="col-md-4 {{ $errors->has('payment_status') ? 'has-error' : ''}}">
                        {{ Form::select('status', ['' => 'Please Payment Status', 'PENDING' => 'PENDING', 'APPROVE' => 'APPROVE','REJECT' => 'REJECT'], null, ['class'=> 'form-control']) }}
                    </div>
                </div>

            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-success">Export Excell</button>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>

@endsection