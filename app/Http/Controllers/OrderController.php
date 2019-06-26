<?php
namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PDF;
use RajaOngkir;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public $table;
    public $key;
    public $field;
    public $model;
    public $template;
    public $rules;
    public $datatable;
    public $searching;
    public $prefix;
    public $codelength;

    public function __construct()
    {
        $this->model      = new \App\Order();
        $this->table      = $this->model->getTable();
        $this->key        = $this->model->getKeyName();
        $this->field      = $this->model->getFillable();
        $this->datatable  = $this->model->datatable;
        $this->rules      = $this->model->rules;
        $this->searching  = $this->model->searching;
        $this->template   = 'order';
        $this->prefix     = "BO" . date("y") . date("m");
        $this->codelength = 10;
    }

    public function index()
    {
        return redirect()->route($this->getModule() . 'read');
    }

    public function create()
    {
        if (request()->isMethod('POST')) {
            $this->validate(request(), $this->rules);
            $code    = $this->Code($this->table, $this->key, $this->prefix, $this->codelength);
            $request = request()->all();
            $file = request()->file('files');
            $this->model->simpan($code, $request, $file);

            $produk  = request()->get('produks');
            $qty     = request()->get('quantity');

            for ($i = 0; $i < count(request()->get('produks')); $i++) {

                $detail = [
                    'detail'     => $code,
                    'product'    => $produk[$i],
                    'qty'        => $qty[$i],
                ];

                $this->model->detail($detail);

                $pro = DB::table('buku');
                $pro->where('buku_id', $produk[$i]);

                $dp = $pro->get()->first();
                $pro->update([
                    'buku_stock' => $dp->buku_stock - $qty[$i]
                ]);

            }

            // $get = $this->model->baca($code)->first();
            // $customer = $get->customer_name;
            // $sales = $get->name;
            // $account = new \App\Account();

            // $email = [
            //     'code' => $code,
            //     'customer' => $customer,
            //     'sales' => $sales,
            //     'header' => $get,
            //     'account' => $account->baca()->where('account_type','=','REKENING')->get(),
            //     'detail' => $this->model->getDetail($code),
            // ];

            // Mail::send('emails.order', $email, function($message) use ($customer,$sales) {
            //                 $message->to(config('mail.from.address'), config('mail.from.name'));
            //                 $message->to(Auth::user()->email, Auth::user()->name);
            //                 $message->subject('Notification Order From Sales');
            //                 $message->from(config('mail.from.address'), $customer.' - '.$sales);
            //         });  

            return redirect()->route($this->getModule() . '_read', ['code' => $code]);

        } else {
            $user   = new \App\User();
            $product    = new \App\Buku();
            $select = $user->baca();
            
            return view('page.' . $this->template . '.create')->with([
                'template'   => $this->template,
                'customer'   => $select->get(),
                'buku'    => $product->baca()->get(),
            ]);
        }
    }

    public function cetak()
    {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);
            $data    = $this->validasi($getData);
            view()->share([
                'data'   => $data,
                'detail' => $this->model->getDetail($id),
                'from'   => RajaOngkir::Kota()->find($data->city_from),
                'to'     => RajaOngkir::Kota()->find($data->city_id),
            ]);

            $pdf = PDF::loadView('page.' . $this->template . '.cetak');
            return $pdf->stream($id . '.pdf');
        }

        return redirect()->route($this->getModule() . '_read');
    }

    public function invoice()
    {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);
            $data    = $this->validasi($getData);
            view()->share([
                'data'   => $data,
                'detail' => $this->model->getDetail($id),
                'from'   => RajaOngkir::Kota()->find($data->city_from),
                'to'     => RajaOngkir::Kota()->find($data->city_id),
            ]);

            $pdf = PDF::loadView('page.' . $this->template . '.invoice');
            return $pdf->stream($id . '.pdf');
        }

        return redirect()->route($this->getModule() . '_read');
    }

    public function delivery_order()
    {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);
            $data    = $this->validasi($getData);
            view()->share([
                'data'   => $data,
                'detail' => $this->model->getDetail($id),
                'from'   => RajaOngkir::Kota()->find($data->city_from),
                'to'     => RajaOngkir::Kota()->find($data->city_id),
            ]);

            $pdf = PDF::loadView('page.' . $this->template . '.delivery_order');
            return $pdf->stream($id . '.pdf');
        }

        return redirect()->route($this->getModule() . '_read');
    }

    public function work_order()
    {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);
            DB::table('orders')->where('order_id', $id)->update(['order_status' => 'PREPARED']);

            view()->share([
                'data'   => $this->validasi($getData),
                'detail' => $this->model->getDetail($id),
            ]);
        }

        $pdf = PDF::loadView('page.' . $this->template . '.deliver');
        return $pdf->stream($id . '.pdf');
    }

    public function read()
    {
        $total_button = 0;
        if (request()->isMethod('POST')) {
            $getData   = $this->model->baca()->latest();
            $datatable = Datatables::of($this->filter($getData))
                ->addColumn('checkbox', function ($select) {
                    $id       = $this->key;
                    $checkbox = '<input type="checkbox" name="id[]" class="chkSelect" style="margin-left:10px;" id="checkbox1" value="' . $select->$id . '">';
                    return $checkbox;
                })->addColumn('action', function ($select) use ($total_button) {
                $id     = $this->key;
                $gabung = '<div class="aksi text-center">';
                if (session()->get('akses.update')) {
                    $gabung = $gabung . '<a href="' . route($this->getModule() . '_update', [
                        'code' => $select->$id]) . '" class="btn btn-xs btn-primary">edit</a> ';
                    $total_button = $total_button + 1;
                }
                if (session()->get('akses.admin')) {
                    $gabung = $gabung . '<a href="' . route($this->getModule() . '_admin', [
                        'code' => $select->$id]) . '" class="btn btn-xs btn-primary">Admin</a> ';
                    $total_button = $total_button + 1;
                }
                if (session()->get('akses.payment')) {
                    $gabung = $gabung . '<a href="' . route($this->getModule() . '_payment', [
                        'code' => $select->$id]) . '" class="btn btn-xs btn-info">Payment</a> ';
                    $total_button = $total_button + 1;
                }

                if (session()->get('akses.finance')) {
                    $gabung = $gabung . '<a href="' . route($this->getModule() . '_finance', [
                        'code' => $select->$id]) . '" class="btn btn-xs btn-info">history</a> ';
                    $total_button = $total_button + 1;
                }

                if (session()->get('akses.receive')) {
                    $gabung = $gabung . '<a href="' . route($this->getModule() . '_receive', [
                        'code' => $select->$id]) . '" class="btn btn-xs btn-danger">receive</a> ';
                    $total_button = $total_button + 1;
                }
                if (session()->get('akses.work_order')) {
                    $gabung = $gabung . '<a target="_blank" href="' . route($this->getModule() . '_work_order', [
                        'code' => $select->$id]) . '" class="btn btn-xs btn-danger">Work Order</a> ';
                    $total_button = $total_button + 1;
                }
                if (session()->get('akses.prepare')) {
                    $gabung = $gabung . '<a href="' . route($this->getModule() . '_prepare', [
                        'code' => $select->$id]) . '" class="btn btn-xs btn-primary">Prepare</a> ';
                    $total_button = $total_button + 1;
                }
                $gabung = $gabung . ' <a href="' . route(Route::currentRouteName(), [
                    'code' => $select->$id]) . '" class="btn btn-xs btn-success">show</a></div>';
                $total_button = $total_button + 1;
               session()->put('button', $total_button);
                return $gabung;
            });

            $awal  = request()->get('awal');
            $akhir = request()->get('akhir');

            if (!empty($awal) && !empty($awal)) {
                $datatable->where('order_date', '>=', $awal);
                $datatable->where('order_date', '<=', $akhir);
            }

            if (request()->has('search')) {
                $code      = request()->get('code');
                $search    = request()->get('search');
                $aggregate = request()->get('aggregate');
                $datatable->where(empty($code) ? $this->searching : $code, empty($aggregate) ? 'like' : $aggregate, "%$search%");
            }

            return $datatable->make(true);
        }

        if (request()->has('code')) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);
            $data    = $this->validasi($getData);

            return view('page.' . $this->template . '.show')->with([
                'fields'   => $this->datatable,
                'data'     => $data,
                'detail'   => $this->model->getDetail($id),
                'key'      => $this->key,
                'template' => $this->template,
            ]);
        }

        return view('page.' . $this->template . '.table')->with(['fields' => $this->datatable,
            'template'                                                        => $this->template]);
    }

    public function deliver()
    {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);

            return view('page.' . $this->template . '.receive')->with([
                'template' => $this->template,
                'data'     => $this->validasi($getData),
                'detail'   => $this->model->getReceive($id),
                'key'      => $this->key,
                'fields'   => $this->datatable,
            ]);
        } else {
            if (request()->isMethod('POST')) {
                $id              = collect(request()->query())->flip()->first();
                $request         = request()->all();
                $file            = request()->file('files');
                // $request['form'] = 'deliver';
                $this->model->ubah($id, $request, $file);
            }
            return redirect()->back();
        }
    }

    public function prepare()
    {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);

            return view('page.' . $this->template . '.receive')->with([
                'template' => $this->template,
                'data'     => $this->validasi($getData),
                'detail'   => $this->model->getReceive($id),
                'key'      => $this->key,
                'fields'   => $this->datatable,
            ]);
        } else {
            if (request()->isMethod('POST')) {
                $id              = collect(request()->query())->flip()->first();
                $request         = request()->all();
                $file            = request()->file('files');
                // $request['form'] = 'deliver';
                $this->model->ubah($id, $request, $file);
            }
            return redirect()->back();
        }
    }

    public function payment()
    {
        $payment = new \App\Payment();
        if (!empty(request()->get('code'))) {
            $id         = request()->get('code');
            $getData    = $this->model->baca($id);
            $total      = $this->model->getDetail($id)->sum('total');
            $pembayaran = $payment->getByReference($id);

            $data = $this->validasi($getData);
            return view('page.' . $this->template . '.payment')->with([
                'template'   => $this->template,
                'data'       => $data,
                'detail'     => $pembayaran->get(),
                'pembayaran' => $pembayaran->sum('approve_amount'),
                'tagihan'    => $total,
                'key'        => $this->key,
                'fields'     => $this->datatable,
                'account'    => DB::table('accounts')->where('account_type', '=', 'REKENING')->get(),
            ]);
        }
        if (!empty(request()->get('delete'))) {
            $id      = request()->get('delete');
            $getData = $payment->baca($id);
            $getData->delete();
            return redirect()->back();
        } else {
            if (request()->isMethod('POST')) {
                $id                         = collect(request()->query())->flip()->first();
                $vprefix                    = "V" . date("y") . date("m");
                $vcodelength                = 15;
                $voucher                    = $this->Code('payments', 'payment_voucher', $vprefix, $vcodelength);
                $amount                     = request()->get('payment_amount');
                $sisa_tagihan               = 0;
                $request                    = request()->all();
                $request['payment_model']   = 'SO';
                $request['payment_type']    = 'PENDING';
                $request['payment_status']  = 'PENDING';
                $request['payment_voucher'] = $voucher;

                if(isset($request['sisa_tagihan'])){
                    $sisa_tagihan = $request['sisa_tagihan'];
                }

                $file = request()->file('files');
                $unic = $this->unic(5);

                $payment->simpan($unic, $request, $file);

                $data = [

                    'data' => request()->all(),
                    'voucher' => $voucher, 
                    'sales' => Auth::user()->name, 
                ];

                Mail::send('emails.payment_customer', $data, function($message){
                            $message->to(config('mail.from.address'), config('mail.from.name'));
                            $message->to(Auth::user()->email, Auth::user()->name);
                            $message->subject('Notification Payment From Sales');
                            $message->from(Auth::user()->email, Auth::user()->name);
                    });   

                return redirect()->back();
                // return redirect()->route($this->getModule().'_payment', ['code' => $request['reference']]);
            } else {
                return view('page.' . $this->template . '.payment')->with([
                    'template'   => $this->template,
                    'list_order' => DB::table('orders')->where('order_status', '!=', 'COMPLETE')->get(),
                ]);

            }
        }
        return redirect()->back();
    }

    // public function finance()
    // {
    //     $payment = new \App\Payment();
    //     if (!empty(request()->get('code'))) {
    //         $id         = request()->get('code');
    //         $getData    = $this->model->baca($id);
    //         $total      = $this->model->getDetail($id)->sum('total');
    //         $pembayaran = $payment->getByReference($id);;

    //         $data = $this->validasi($getData);
    //         // dd($data);
    //         return view('page.' . $this->template . '.finance')->with([
    //             'template'   => $this->template,
    //             'data'       => $data,
    //             'detail'     => $pembayaran->get(),
    //             'pembayaran' => $pembayaran->sum('approve_amount'),
    //             'tagihan'    => $total,
    //             'key'        => $this->key,
    //             'fields'     => $this->datatable
    //         ]);
    //     }
    //     if (!empty(request()->get('approve'))) {
    //         $id      = request()->get('approve');
    //         $amount      = request()->get('amount');

    //         $code        = $this->Code($this->table, $this->key, $this->prefix, $this->codelength);
    //         $vprefix     = "V" . date("y") . date("m");
    //         $vcodelength = 15;
    //         $voucher     = $this->Code('payments', 'payment_voucher', $vprefix, $vcodelength);
    //         $getData = $payment->baca($id);
    //         // $amount = $getData->first()->payment_amount;

    //         $getData->update([
    //             'approved_by' => Auth::user()->name, 
    //             'approve_date' => date('Y-m-d H:i:s'), 
    //             'approve_amount' => $amount, 
    //             'payment_type' => 'IN', 
    //             'payment_status' => 'APPROVED', 
    //         ]);
    //         return redirect()->back();
    //     } else {
    //         if (request()->isMethod('POST')) {
    //             $id                         = collect(request()->query())->flip()->first();
    //             $vprefix                    = "V" . date("y") . date("m");
    //             $vcodelength                = 15;
    //             $voucher                    = $this->Code('payments', 'payment_voucher', $vprefix, $vcodelength);
    //             $amount                     = request()->get('payment_amount');
    //             $sisa_tagihan               = 0;
    //             $request                    = request()->all();
    //             $request['payment_model']   = 'SO';
    //             $request['payment_type']    = 'PENDING';
    //             $request['payment_status']  = 'PENDING';
    //             $request['payment_voucher'] = $voucher;

    //             if(isset($request['sisa_tagihan'])){
    //                 $sisa_tagihan = $request['sisa_tagihan'];
    //             }

    //             $file = request()->file('files');
    //             $unic = $this->unic(5);

    //             $payment->simpan($unic, $request, $file);

    //             return redirect()->back();
    //             // return redirect()->route($this->getModule().'_payment', ['code' => $request['reference']]);
    //         } else {
    //             return view('page.' . $this->template . '.finance')->with([
    //                 'template'   => $this->template,
    //                 'list_order' => DB::table('orders')->where('order_status', '!=', 'COMPLETE')->get(),
    //                 'account'    => DB::table('accounts')->where('account_type', '=', 'REKENING')->get(),
    //             ]);

    //         }
    //     }
    //     return redirect()->back();
    // }

    public function print_history_payment() {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $payment = new \App\Payment();
            $getData = $this->model->baca($id);
            view()->share([
                'data'    => $this->validasi($getData),
                'detail'    => $payment->getByReference($id)->get(),
            ]);

            $pdf = PDF::loadView('page.' . $this->template . '.print_history_payment');
            return $pdf->stream($id . '.pdf');
        }

        return redirect()->route($this->getModule() . '_read');
    }

    public function berita_acara()
    {

        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);

            view()->share([
                'data'   => $this->validasi($getData),
                'detail' => $this->model->getDetail($id),
            ]);

            $pdf = PDF::loadView('page.' . $this->template . '.berita_acara');
            return $pdf->stream($id . '.pdf');
        }
    }

    public function update()
    {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);

            $buku = new \App\Buku();
            $user = new \App\User();

            return view('page.' . $this->template . '.edit')->with([
                'template' => $this->template,
                'data'     => $this->validasi($getData),
                'detail'   => $this->model->getDetail($id),
                'key'      => $this->key,
                'buku'     => $buku->baca()->get(),
                'customer' => $user->baca($getData->first()->id_user)->get(),
                'fields'   => $this->datatable,
            ]);

        } else {
            if (request()->isMethod('POST')) {
                // dd(request()->all());
                $id              = collect(request()->query())->flip()->first();
                $request         = request()->all();
                $this->model->ubah($id, $request);

            }
            return redirect()->back();
        }
    }

    public function admin()
    {
        if (!empty(request()->get('code'))) {
            $id      = request()->get('code');
            $getData = $this->model->baca($id);

            return view('page.' . $this->template . '.admin')->with([
                'template' => $this->template,
                'data'     => $this->validasi($getData),
                'detail'   => $this->model->getDetail($id),
                'key'      => $this->key,
                'fields'   => $this->datatable,
            ]);
        } else {
            if (request()->isMethod('POST')) {
                $id              = collect(request()->query())->flip()->first();
                $request         = request()->all();
                $file            = request()->file('files');
                $this->model->ubah($id, $request, $file);
            }
            return redirect()->back();
        }
    }

    public function delete()
    {
        $input = request()->all();
        $this->model->cancel(request()->get('id'));
        return redirect()->back();
    }

}
