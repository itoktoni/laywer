@extends('backend.'.config('website.backend').'.layouts.app') @section('content')
<div class="row">
    @isset($data)
    {!! Form::model($data, ['route'=>[$form.'_payment', $data->$key],'class'=>'form-horizontal','files'=>true]) !!}
    @else
    {!! Form::open(['route' => $form.'_payment', 'class' => 'form-horizontal', 'files' => true]) !!} 
    @endisset
    <div class="panel panel-default" style="margin-bottom: 300px;">
        <header class="panel-heading">
            <h2 class="panel-title">History Pembayaran</h2>
        </header>
        <div class="panel-body">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label">No order</label>
                    <div class="col-md-4 {{ $errors->has('reference') ? 'has-error' : ''}}">
                        <select class="form-control option" name="reference">
                            <option selected=" " value="{{ isset($data->order_id) ? $data->order_id : '' }}">
                                {{ isset($data->order_id) ? $data->order_id : 'Silahkan Pilih order' }}
                            </option>
                            @isset($list_order) 
                            @foreach($list_order as $value)
                            <option @isset($data) {{ $value->order_id == $data->order_id ? 'selected="selected"' : '' }} @endisset value="{{ $value->order_id }}"> {{ $value->order_id }}
                            </option>
                            @endforeach 
                            @endisset
                        </select>
                    </div>
                    <label class="col-md-2 control-label">Tanggal Transfer</label>
                    <div class="col-md-4 {{ $errors->has('payment_date') ? 'has-error' : ''}}">
                        <input type="text" class="form-control" readonly="" value="{{$data->customer_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama Sales</label>
                    <div class="col-md-4 {{ $errors->has('payment_person') ? 'has-error' : ''}}">
                        <input type="text" class="form-control" readonly="" value="{{ $data->name }}">
                    </div>
                    <label class="col-md-2 control-label">Tanggal Order</label>
                    <div class="col-md-4 {{ $errors->has('account_From') ? 'has-error' : ''}}">
                       <input type="text" class="form-control" readonly="" value="{{ $data->order_date }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="textareaDefault">Estimasi Pengiriman</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" readonly="" value="{{ number_format($data->estimasi_cost) }}">
                        <h2 class="text-right">
                            @isset($tagihan)
                              Sisa Hutang : {{ number_format(($tagihan + $data->estimasi_cost)-$pembayaran) }} 
                            @endisset
                        </h2>
                    </div>
                    <label class="col-md-2 control-label">Catatan Tambahan</label>
                    <div class="col-md-4">
                        {!! Form::textarea('', $data->customer_address.' : '.$data->courier_service , ['readonly' => '', 'class' => 'form-control', 'rows' => '3']) !!}
                    </div>
                </div>
                @isset($key)
                <hr>

                <div class="form-group">
                    <table class="table table-no-more table-bordered table-striped mb-none">
                        <thead>
                            <tr>
                                <th width="50" class="text-left">ID</th>
                                <th width="100" class="text-left">From</th>
                                <th width="100" class="text-left">TO</th>
                                <th  width="120" class="text-left">Nama Pemilik</th>
                                <th width="100" class="text-right">Nilai Transfer</th>
                                <th width="100" class="text-right">Attachment</th>
                                <th class="text-left">Note</th>
                                <th  width="80" class="text-center">Status</th>
                                <th  width="120" class="text-left">Approved By</th>
                                <th  width="80" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($detail) > 0)
                            @php
                            $total = 0;
                            @endphp                        
                            @foreach ($detail as $value)
                            @php
                            $amount = $value->payment_amount;
                            $total = $total + $amount;
                            @endphp
                            <tr>
                                <td data-title="ID">{{ $value->payment_id }}</td>
                                <td data-title="From">{{ $value->account_from }}</td>
                                <td data-title="TO">{{ $value->account_to }}</td>
                                <td data-title="Name">{{ $value->payment_person }}</td>
                                <td data-title="Amount" align="right">{{ number_format($value->payment_amount) }}</td>
                                <td data-title="Attachment" align="center">
                                    <a target="_blank" class="btn btn-primary btn-xs" href="{{asset('public/files/payment/'.$value->payment_attachment)}}">{{ $value->payment_attachment }}</a>
                                </td>
                                <td data-title="Note">{{ $value->payment_description }}</td>
                                <td data-title="Status">{{ $value->payment_status }}</td>
                                <td align="center" data-title="Approve">{{ isset($value->approved_by) ? $value->approved_by : '-' }}</td>
                                <td align="center" data-title="Action">
                                    <a class="btn btn-success btn-xs" href="{{ route($form.'_finance', ['approve' => $value->payment_id, 'amount' => $value->payment_amount]) }}">Approve</a>
                                </td>
                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="9" class="text-right">
                                    <strong class="text-center text-info"> 
                                        Total Pesanan
                                    </strong>
                                </td>
                                <td colspan="1" class="text-right">
                                    <strong class="text-center text-info"> 
                                     {{ number_format($tagihan) }}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="text-right">
                                    <strong class="text-center text-warning"> 
                                        Biaya Pengiriman
                                    </strong>
                                </td>
                                <td colspan="1" class="text-right">
                                    <strong class="text-center text-warning"> 
                                     {{ number_format($data->estimasi_cost) }}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="text-right">
                                    <strong class="text-center text-danger"> 
                                        Total Tagihan
                                        <input type="hidden" value="{{$tagihan}}" name="total_tagihan">
                                    </strong>
                                </td>
                                <td colspan="1" class="text-right">
                                    <strong class="text-center text-danger"> 
                                     {{ number_format($tagihan+$data->estimasi_cost) }}
                                    </strong>
                                </td>
                            </tr>
                             
                            <tr>
                                <td colspan="9" class="text-right">
                                    <strong class="text-center text-success"> 
                                        Total Pembayaran
                                    </strong>
                                </td>
                                <td colspan="1" class="text-right">
                                    <strong class="text-center text-success"> 
                                     {{ number_format($pembayaran) }}
                                    </strong>
                                </td>
                            </tr>
                             @else
                             <tr>
                                <td colspan="10" class="text-center">
                                    <strong class="text-center text-danger"> 
                                        Data Pembayaran {{ $data->order_id }} masih Kosong ! 
                                    </strong>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="9" class="text-right">
                                    <strong class="text-center text-primary"> 
                                        Sisa Tagihan
                                        <input type="hidden" value="{{ $tagihan }}" name="sisa_tagihan">
                                    </strong>
                                </td>
                                <td colspan="1" class="text-right">
                                    <strong class="text-center text-primary"> 
                                     {{ number_format(($tagihan+$data->estimasi_cost)-$pembayaran) }}
                                    </strong>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
            @endisset
        </div>
    </div>

    <div class="navbar-fixed-bottom" id="menu_action">
        <div class="text-right" style="padding:5px">
            <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
            <button type="reset" class="btn btn-default">Reset</button>
            @if(isset($update) || isset($payment))  
            <button type="submit" class="btn btn-primary">Save</button>
            @endisset 
            @isset($print_history_payment)
                <a target="_blank" href="{!! route("{$form}_print_history_payment", ["code" => $data->$key]) !!}" class="btn btn-danger">Cetak PDF
                </a>
            @endisset
        </div>
    </div>
</div>
</div>
{!! Form::close() !!} @endsection