<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('public/assets/css/print.css') }}" media="all" rel="stylesheet" />
</head>
<body>
    <div id='page'>
        <div>
            <div style="margin-bottom: 0px;clear: both;width: 100%;">
                <h4 style='text-align: center; color:white;line-height: 0;font-size: 1.2em; font-weight: bold;'>
                    History Pembayaran ( {{ $data->order_id }} )
                </h4>
                <h5 style="text-align: center;">
                    <img style="margin-top: 30px;text-align: center;" src="data:image/png;base64,{{BARCODE1D::getBarcodePNG($data->order_id, 'C128')}}" alt="barcode"/>
                    <h5>
                        <div>
                            <div style="margin-top: 0px;">    
                                <table border='0.4' cellpadding='5' cellspacing='0' id='templateList' width='100%'>
                                    <tr>
                                        <td colspan='7' style='background: #a30046 !important;color: white;'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='2' valign='top'>
                                            Reference
                                        </td>
                                        <td align='left' colspan='5' valign='top'>
                                            <strong>{{ $data->order_id }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='2' valign='top'>
                                            Tanggal Cetak
                                        </td>
                                        <td align='left' colspan='5' valign='top'>
                                            <strong>
                                                {{ date_format(date_create($data->payment_date),"d F Y") }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='2' valign='top'>
                                            Customer
                                        </td>
                                        <td align='left' colspan='5' valign='top'>
                                            <strong>{{ $data->customer_name }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='2' valign='top'>
                                            Sales
                                        </td>
                                        <td align='left' colspan='5' valign='top'>
                                            <strong>{{ $data->name }}</strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan='7' style='background: #a30046 !important'></th>
                                    </tr>
                                    <tr>
                                        <td align='left' width="20px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>No.</strong>
                                        </td>
                                        <td align='left' width="80px;"  colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Payment Voucher</strong>
                                        </td>
                                        <td align='left' width="100px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Account From</strong>
                                        </td>
                                        <td align='right' width="100px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Account To</strong>
                                        </td>
                                        <td align='right' colspan='1' width="100px;" style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Person</strong>
                                        </td>
                                         <td align='right' colspan='1' width="100px;" style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Tanggal Transfer</strong>
                                        </td>

                                        <td align='right' width="100px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Value</strong>
                                        </td>
                                        
                                    </tr>
                                    @php
                                    $total = 0;
                                    $hitung = 0;
                                    @endphp
                                    @foreach($detail as $value)
                                    @php
                                    $total = $total + $value->approve_amount;
                                    $hitung = $hitung + 1;
                                    @endphp
                                    <tr>
                                        <td align='left' width="20px;" colspan='1' style='background-color: #00000 !important' valign='top'>
                                            <strong>{{$hitung}}</strong>
                                        </td>
                                        <td align='left' colspan='1' style='background-color: #00000 !important' valign='top'>
                                            <strong>
                                                {{ $value->payment_voucher }}
                                            </strong>
                                        </td>
                                         <td align='left' colspan='1' style='background-color: #00000 !important' valign='top'>
                                            <strong>
                                                {{ $value->account_from }}
                                            </strong>
                                        </td>
                                        <td align='right' width="100px;" colspan='1' style='background-color: #00000 !important' valign='top'>
                                            <strong>{{ $value->account_to }}</strong>
                                        </td>
                                         <td align='right' colspan='1' width="100px;" style='background-color: #00000 !important' valign='top'>
                                            <strong>{{ $value->payment_person }}</strong>
                                        </td>
                                         <td align='right' colspan='1' width="100px;" style='background-color: #00000 !important' valign='top'>
                                            <strong>{{ $value->payment_date }}</strong>
                                        </td>
                                        <td align='right' width="100px;" colspan='1' style='background-color: #00000 !important' valign='top'>
                                            <strong>{{ number_format($value->payment_amount) }}</strong>
                                        </td>
                                       
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>TOTAL PEMBAYARAN</strong>
                                        </td>
                                        <td align='right' class='grandTotal' colspan='1' valign='top'>
                                            <strong><span class='currency positive'></span><span class='amount positive'> {{ number_format($total) }}</span></strong>
                                        </td>
                                    </tr>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @isset($data->payment_status)
                    <div align='left' style='padding:2px 10px;margin-top: 10px;background-color: #e0e0e0 !important'>
                        <p>
                            <strong>
                               Note : Status ( {{ $data->payment_status }} ) - {{ $data->payment_note }}   
                           </strong>
                       </p>
                   </div>
                   @endisset

                   <div align="right" style='margin-top: 10px;'>
                    <span style="margin-top: 50px;"> Approved By&nbsp;</span>
                    <p style="margin-top: 70px;">
                        <strong>
                          <br>
                          ( {{ Auth::user()->name }} )
                      </strong>
                  </p>
              </div>

          </div>
      </body>
      </html>