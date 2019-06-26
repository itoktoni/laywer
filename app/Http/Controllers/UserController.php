<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AccessMenu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{

    public $table;
    public $key;
    public $field;
    public $model;
    public $template;
    public $rules;
    public $datatable;
    public $searching;
    public $render;

    public function __construct(User $abstrak)
    {
        $this->table     = $abstrak->getTable();
        $this->key       = $abstrak->getKeyName();
        $this->field     = $abstrak->getFillable();
        $this->model     = $abstrak;
        $this->template  = 'user';
        $this->searching = 'name';
        $this->rules     = [
            'name'     => 'required|min:3',
            'username' => 'required|min:3|unique:' . $this->table,
            'email'    => 'required|min:3|email|unique:' . $this->table,
            'password' => 'required|min:3',
        ];
        $this->datatable = [
            'user_id'    => 'ID',
            'name'       => 'Top ID',
            'email'      => 'Email',
            'username'   => 'Username',
            'group_user' => 'Group',
            'site_id'    => 'Site',
        ];
    }

    public function index()
    {
        return view('home');
    }

    public function groups($code, Request $request)
    {
        session()->put(Auth::User()->username . '_group_access', $code);
        return redirect()->back();
    }

    public function create()
    {
        if (request()->isMethod('POST')) {
            $this->validate(request(), $this->rules);
            $this->model->simpan(request()->all());
        }

        $group = new \App\GroupUser;
        return view('page.' . $this->template . '.create')->with([
            'template' => $this->template,
            'grub'     => $group->get(),
        ]);
    }

    public function showProfile(AccessMenu $akses)
    {
        if (request()->isMethod('POST')) {
            $id   = request()->get('user_id');
            $file = request()->file('gambar');
            $this->model->ubah($id, request()->all(), $file);
        }

        $akses->setData($akses->getData());
        return view('page.' . $this->template . '.profile')->with([
            'key'  => Auth::user()->user_id,
            'data' => $this->model->select()->where('user_id', '=', Auth::user()->user_id),
        ]);
    }

    public function resetpassword()
    {
        return view('auth.lock');
    }

    public function change_password(Request $request)
    {

        $this->validate($request, [
            'change_password' => 'required|min:8',
        ]);

        $password = $request->input('change_password');
        $user     = $this->model->update_password(Auth::User()->user_id, $password);

        $to_email = $request->input('email');
        Mail::to($to_email)->send(new \App\Mail\Dashboard($to_email, $password));

        return redirect()->back()->with('sukses', $user);
    }

    public function resetRedis()
    {
        if (Auth::check()) {

            $key = $this->key;
            Cache::forget('App\User_By_Id_' . Auth::user()->$key);
            Cache::forget(Auth::user()->username . '_access_menu');
            Cache::forget('tables');
            Auth::logout();
        }
        return redirect()->to('/');
    }

    public function resetRouting()
    {
        $this->resetRedis();
        Cache::forget('routing');

        return redirect()->to('/');
    }

    public function list()
    {

        if (request()->isMethod('POST')) {
            $datatable = Datatables::of(User::get());
            return $datatable->make(true);
        }

        if (request()->has('code')) {
            $id = request()->get('code');
            return view('page.' . $this->template . '.show')->with([
                'fields'   => $this->datatable,
                'data'     => $this->validasi($this->model->baca(), $id)->first(),
                'detail'   => $this->validasi($this->model->baca(), $id),
                'key'      => $this->key,
                'template' => $this->template,
            ]);
        }

        return view('page.' . $this->template . '.table')->with([
            'fields'   => $this->datatable,
            'template' => $this->template,
        ]);
    }

    public function update()
    {
        if (!empty(request()->get('code'))) {
            $id = request()->get('code');

            return view('action.edit')->with([
                'template' => $this->template,
                'data'     => $this->validasi($this->model->baca(), $id),
                'key'      => $this->key,
            ]);
        } else {

            if (request()->isMethod('POST')) {
                $id          = collect(request()->query())->flip()->first();
                $action      = $this->model->baca($id);
                $requestData = request()->all();
                $action->ubah($requestData);

                header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
            }
            return redirect()->route($this->template . '_read');
        }
    }

    public function delete()
    {
        $input = request()->all();
        $this->model->hapus($input);

        return redirect()->back();
    }

}
