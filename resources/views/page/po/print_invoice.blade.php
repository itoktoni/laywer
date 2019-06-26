<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('public/assets/css/print.css') }}" media="all" rel="stylesheet" />
</head>
<body>
    <div id='page'>
        <div>
            <div style="margin-bottom: 20px;margin-top:-30px;clear: both;">
                <h4 style='text-align: center; color:white;line-height: 0;font-size: 1.2em; font-weight: bold;'>
                    INVOICE ( {{ str_replace('PO','INV',$data->purchase_id) }} )
                </h4>
                
                <h5 style="text-align: center;">
                    <img style="margin-top: 40px;text-align: center;" src="data:image/png;base64,{{BARCODE1D::getBarcodePNG($data->purchase_id, 'C128')}}" alt="barcode"/>
                    <h5>
                        <div>
                            <div style="margin-top: 30px;">     
                                <table border='0.4' cellpadding='5' cellspacing='0' id='templateList' width='100%'>
                                    <tr>
                                        <td colspan='9' style='background: #a30046 !important;color: white;'>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='3' valign='top'>
                                            Invoice To
                                        </td>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>{{ config('app.name') }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='3' valign='top'>
                                            Office Address
                                        </td>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>{{ config('website.address') }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='3' valign='top'>
                                            Telp
                                        </td>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>{{ config('website.phone') }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' colspan='3' valign='top'>
                                            Tanggal Buat
                                        </td>
                                        <td align='left' colspan='6' valign='top'>
                                            <strong>
                                                {{ date_format(date_create($data->purchase_date),"d F Y") }}
                                            </strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan='9' style='background: #a30046 !important'></th>
                                    </tr>
                                    <tr>
                                        <td align='left' width="50px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>No.</strong>
                                        </td>
                                        <td align='left' colspan='4' style='background-color: #e0e0e0 !important;' valign='top'>
                                            <strong>Nama Product</strong>
                                        </td>
                                        <td align='right' width="100px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Qty</strong>
                                        </td>
                                        <td align='right' width="100px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Price</strong>
                                        </td>
                                        <td align='right' colspan='2' style='background-color: #e0e0e0 !important' valign='top'>
                                            <strong>Sub Total</strong>
                                        </td>
                                    </tr>
                                    @php
                                    $urut = 0;
                                    $total = 0;
                                    $sub_total = 0;
                                    @endphp
                                    @foreach($detail as $d)
                                    @php
                                    $sub_total =  $d->qty_prepare * $d->price;
                                    $urut = $urut +1;
                                    $total = $total + $sub_total;
                                    @endphp
                                    <tr>
                                        <td align='left' width="30" colspan="1" valign='middle'>
                                            <a class='product-name-link' href='#' style='; text-decoration: none;'>
                                                {{ $urut }}
                                            </a>
                                        </td>
                                        <td align='left' colspan='4' valign='middle'>
                                            <a class='product-name-link' href='#' style='; text-decoration: none;'>
                                                {{ $d->product_name }}
                                            </a>
                                        </td>
                                        <td align='right' colspan='1' valign='middle'>
                                            {{ $d->qty_prepare }}
                                        </td>
                                        <td align='right' colspan='1' valign='middle'>
                                            {{ $d->price }}
                                        </td>
                                        <td align='right' colspan='2' valign='middle'>
                                         {{ number_format($sub_total) }}
                                      </td>
                                  </tr>
                                  @endforeach

                                  <tr>
                                    <td align='left' colspan='7' valign='top'>
                                        <strong>TOTAL YARD</strong>
                                    </td>
                                    <td align='right' class='grandTotal' colspan='2' valign='top'>
                                        <strong><span class='currency positive'></span><span class='amount positive'> {{ number_format($total) }}</span></strong>
                                    </td>
                                </tr>
                            </tr>
                        </table>
                    </div>
                </div>

                @isset($data->purchase_note_supplier)
                <div align='left' style='padding:2px 10px;margin-top: 10px;background-color: #e0e0e0 !important'>
                    <p>
                        <strong>
                         Note : {{ $data->purchase_note_supplier }}   
                     </strong>

                 </p>
             </div>
             @endisset

             <div align="right" style='margin-top: 10px;'>
                <span style="margin-top: 50px;"> Approved By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <p style="margin-top: 70px;">
                    <strong>
                      <br>
                      ( {{ $data->supplier_owner }} )
                  </strong>
              </p>
          </div>

      </div>
  </body>
  </html>