<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('public/assets/css/print.css') }}" media="all" rel="stylesheet" />
</head>
<body>
    <div id='page'>
        <div>
            <div style="margin-bottom: 20px;clear: both;">
                <h4 style='text-align: center; color:white;line-height: 0;font-size: 1.2em; font-weight: bold;'>
                    PURCHASE ORDER ( {{ $data->purchase_id }} )
                </h4>

                <div>
                    <div style="margin-top: 40px;">    
                        <table border='0.4' cellpadding='5' cellspacing='0' id='templateList' width='100%'>
                            <tr>
                                <td colspan='8' style='background: #a30046 !important;color: white;'>

                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='2' valign='top'>
                                    Nama Supplier
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>{{ $data->supplier_name }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='2' valign='top'>
                                    Alamat Supplier
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>{{ $data->supplier_alamat }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='2' valign='top'>
                                    Telp Supplier
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>{{ $data->supplier_telp }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='2' valign='top'>
                                    Tanggal Buat
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>
                                        {{ date_format(date_create($data->purchase_date),"d F Y") }}
                                    </strong>
                                </td>
                            </tr>

                            <tr>
                                <th colspan='8' style='background: #a30046 !important'></th>
                            </tr>
                            <tr>
                                <td align='left' width="50px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                    <strong>No.</strong>
                                </td>
                                <td align='left' colspan='4' style='background-color: #e0e0e0 !important' valign='top'>
                                    <strong>Nama Product</strong>
                                </td>
                                <td align='right' width="100px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                    <strong>Yard</strong>
                                </td>
                                <td align='right' width="150px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                    <strong>Harga</strong>
                                </td>
                                <td align='right' colspan='1' width="150px;" style='background-color: #e0e0e0 !important' valign='top'>
                                    <strong>Total</strong>
                                </td>
                            </tr>
                            @php
                            $urut = 0;
                            $total = 0;
                            @endphp
                            @foreach($detail as $d)
                            @php
                            $urut = $urut +1;
                            $total = $total + $d->total;
                            @endphp
                            <tr>
                                <td align='left' colspan="1" valign='middle'>
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
                                    {{ $d->qty }}
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <strong>
                                        <span class='currency positive'>Rp</span><span class='amount positive'> {{ number_format($d->price) }},-</span>
                                    </strong>
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <strong>
                                        <span class='currency positive'>Rp</span><span class='amount positive'> {{ number_format($d->total) }},-</span>
                                    </strong>
                                </td>
                            </tr>
                            @endforeach

                            <tr>
                                <td align='left' colspan='7' valign='top'>
                                    <strong>TOTAL PEMBAYARAN</strong>
                                </td>
                                <td align='right' class='grandTotal' colspan='1' valign='top'>
                                    <strong><span class='currency positive'>Rp</span><span class='amount positive'> {{ number_format($total) }},-</span></strong>
                                </td>
                            </tr>
                        </tr>
                    </table>
                </div>
            </div>

            @isset($data->purchase_note)
            <div align='left' style='padding:2px 10px;margin-top: 10px;background-color: #e0e0e0 !important'>
                <p>
                    <strong>
                     Note : {{ $data->purchase_note }}   
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