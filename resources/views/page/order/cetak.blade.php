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
                    BOOKING CONFIRMATION ( {{ $data->order_id }} )
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
                                    Nama Customer
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>{{ $data->customer_name }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='2' valign='top'>
                                    Contact Person
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>{{ $data->customer_contact }}</strong>
                                </td>
                            </tr>
                             <tr>
                                <td align='left' colspan='2' valign='top'>
                                    Phone
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>{{ $data->customer_phone }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='2' valign='top'>
                                    Tanggal Buat
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>
                                        {{ date_format(date_create($data->order_date),"d F Y") }}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='2' valign='top'>
                                    Alamat Customer
                                </td>
                                <td align='left' colspan='6' valign='top'>
                                    <strong>{{ ucwords($data->order_address) }} ( Provinsi {{ $to['province'] }} {{ $to['type'] }} {{ $to['city_name'] }} )</strong>
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
                                    <strong>Nama Product</strong>
                                </td>
                                <td align='right' width="100px;" colspan='1' style='background-color: #e0e0e0 !important' valign='top'>
                                    <strong>Qty</strong>
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
                            $jumlah = 0;
                            @endphp
                            @foreach($detail as $d)
                            @php
                            $urut = $urut +1;
                            $jumlah = $d->qty * $d->price;
                            $total = $total + $jumlah;
                            @endphp
                            <tr>
                                <td align='center' colspan="1" valign='middle'>
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
                                    {{ round($d->qty) }} {{ $d->product_unit }}
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <strong>
                                        <span class='currency positive'></span><span class='amount positive'> {{ number_format($d->price) }}</span>
                                    </strong>
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <strong>
                                        <span class='currency positive'></span><span class='amount positive'> {{ number_format($jumlah) }}</span>
                                    </strong>
                                </td>
                            </tr>
                            @endforeach
                             <tr>
                                <td align='left' colspan='7' valign='middle'>
                                    <strong>Estimasi Pengiriman</strong>
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <strong>
                                        <span class='currency positive'></span><span class='amount positive'> {{ number_format($data->estimasi_cost) }}</span>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='7' valign='middle'>
                                    <strong>Total Pembayaran</strong>
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <strong>
                                        <span class='currency positive'></span><span class='amount positive'> {{ number_format($total) }}</span>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='7' valign='middle'>
                                    <strong>TOTAL TAGIHAN </strong>
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <strong>
                                        <span class='currency positive'></span><span class='amount positive'> {{ number_format($total + $data->estimasi_cost) }}</span>
                                    </strong>
                                </td>
                            </tr>
                        </tr>
                    </table>
                </div>
            </div>

            @isset($data->order_note)
            <div align='right' style='padding:2px 10px;margin-top: 10px;background-color: #e0e0e0 !important'>
                <p>
                    <strong>
                       Note : {{ $data->order_note }}   
                   </strong>

               </p>
           </div>
           @endisset
            
           <div align='left' style='padding:2px 10px;margin-top: 10px;background-color: #a30046 !important;'>
                <p>
                    <strong style="color: white !important;">
                       Notes : Estimasi Pengiriman :  {{ $data->qty_total/1000 }} Kg = {{ strtoupper($data->courier) }} - {{ $data->courier_service }} # Rp. {{ number_format($data->estimasi_cost) }} #  
                   </strong>
               </p>
           </div>

           <div align="right" style='margin-top: 10px;'>
            <span style="margin-top: 50px;"> Support By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <p style="margin-top: 70px;">
                <strong>
                  <br>
                  ( {{ ucwords($data->name) }} )
              </strong>
          </p>
      </div>

  </div>
</body>
</html>