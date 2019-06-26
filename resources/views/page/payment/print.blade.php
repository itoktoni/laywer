<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('public/assets/css/print.css') }}" media="all" rel="stylesheet" />
</head>
<body>
    <div id='page'>
        <div>
            <div style="margin-bottom: 0px;clear: both;">
                <h4 style='text-align: center; color:white;line-height: 0;font-size: 1.2em; font-weight: bold;'>
                    Payment Voucher ( {{ $data->payment_voucher }} )
                </h4>
                <h5 style="text-align: center;">
                    <img style="margin-top: 30px;text-align: center;" src="data:image/png;base64,{{BARCODE1D::getBarcodePNG($data->payment_voucher, 'C128')}}" alt="barcode"/>
                    <h5>
                        <div>
                            <div style="margin-top: 0px;">    
                                <table border='0.4' cellpadding='5' cellspacing='0' id='templateList' width='100%'>
                                    <tr>
                                        <td colspan='8' style='background: #a30046 !important;color: white;'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='2' valign='top'>
                                            Reference
                                        </td>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>{{ $data->reference }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='2' valign='top'>
                                            Tanggal Buat
                                        </td>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>
                                                {{ date_format(date_create($data->payment_date),"d F Y") }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='2' valign='top'>
                                            Reference Person
                                        </td>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>{{ $data->payment_person }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='2' valign='top'>
                                            Payment Description
                                        </td>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>{{ $data->payment_description }}</strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan='8' style='background: #a30046 !important'></th>
                                    </tr>
                                    <tr>
                                        <td align='left' width="30px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>No.</strong>
                                        </td>
                                        <td align='left' colspan='4' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Account From</strong>
                                        </td>
                                        <td align='right' width="100px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Account To</strong>
                                        </td>
                                        <td align='right' width="150px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Value</strong>
                                        </td>
                                        <td align='right' colspan='1' width="150px;" style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Person</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' width="30px;" colspan='1' style='background-color: #00000 !important' valign='top'>
                                            <strong>No.</strong>
                                        </td>
                                        <td align='left' colspan='4' style='background-color: #00000 !important' valign='top'>
                                            <strong>
                                                {{ $account }}
                                            </strong>
                                        </td>
                                        <td align='right' width="100px;" colspan='1' style='background-color: #00000 !important' valign='top'>
                                            <strong>{{ $data->account_to }}</strong>
                                        </td>
                                        <td align='right' width="150px;" colspan='1' style='background-color: #00000 !important' valign='top'>
                                            <strong>{{ number_format($data->payment_amount) }}</strong>
                                        </td>
                                        <td align='right' colspan='1' width="150px;" style='background-color: #00000 !important' valign='top'>
                                            <strong>{{ $data->payment_person }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='7' valign='top'>
                                            <strong>TOTAL PEMBAYARAN</strong>
                                        </td>
                                        <td align='right' class='grandTotal' colspan='1' valign='top'>
                                            <strong><span class='currency positive'>Rp</span><span class='amount positive'> {{ number_format($data->payment_amount) }},-</span></strong>
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
                    <span style="margin-top: 50px;"> Approved By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <p style="margin-top: 70px;">
                        <strong>
                          <br>
                          ( {{ config('website.owner') }} )
                      </strong>
                  </p>
              </div>

          </div>
      </body>
      </html>