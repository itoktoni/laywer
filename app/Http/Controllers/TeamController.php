<?php
namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Helper;

class TeamController extends Controller
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

    public function __construct()
    {
        $this->model     = new \App\User();
        $this->table     = $this->model->getTable();
        $this->key       = $this->model->getKeyName();
        $this->field     = $this->model->getFillable();
        $this->datatable = $this->model->datatable;
        $this->rules     = $this->model->rules;
        $this->searching = $this->model->searching;
        $this->template  = 'user';
        $this->render    = 'page.' . $this->template . '.';

    }

    public function index()
    {
        return redirect()->route($this->getModule() . 'list');
    }

    public function create()
    {
        if (request()->isMethod('POST')) {
            $code = $this->Code('users', 'user_id', 'U' . date('Y') . date('m'), 10);
            $this->validate(request(), $this->rules);
            $this->model->simpan(request()->all(), $code);
            return redirect()->route($this->getModule() . '_update', ['code' => $code]);
        } else {
            $group = new \App\GroupUser();
            return view('page.' . $this->template . '.create')->with([
                'template' => $this->template,
                'group'    => $group->baca()->get(),
            ]);
        }

    }

    function list() {

        if (request()->isMethod('POST')) {
            $getData   = $this->model->baca();
            $datatable = Datatables::of($this->filter($getData));
            $datatable->editColumn('checkbox', function ($select) {
                return Helper::createCheckbox($select->{$this->key});
            });
            $datatable->editColumn('active', function ($select) {
                return Helper::createStatus([
                    'value'   => $select->active,
                    'status'  => $this->model->status,
                ]);
            });
            $datatable->addColumn('action', function ($select) {
                $action = [
                    'update' => ['primary', 'edit'],
                    'list'   => ['success', 'show'],
                ];

                if (!session()->exists('button')) {
                    session()->put('button', count($action));
                }
                $data = Helper::createAction([
                    'key'    => $select->{$this->key},
                    'route'  => $this->getModule(),
                    'action' => $action,
                ]);
                return $data;
            });
            $datatable->rawColumns(['active','action','checkbox']);
            if (!empty(request()->get('search'))) {
                $datatable->filter(function ($query) {
                    $code         = request()->get('code');
                    $search       = request()->get('search');
                    $aggregate    = request()->get('aggregate');
                    $search_field = empty($code) ? $this->model->searching : $code;
                    $aggregation  = empty($aggregate) ? 'like' : $aggregate;
                    $input        = empty($aggregate) ? "%$search%" : "$search";
                    $query->where($search_field, $aggregation, $input);
                });
            }

            return $datatable->make(true);
        }

        if (request()->has('code')) {
            $id = request()->get('code');
            return view($this->render . '.show')->with([
                'fields'   => Helper::listData($this->datatable),
                'data'     => $this->validasi($this->model->baca($id)),
                'detail'   => $this->model->getDetail($id)->get(),
                'key'      => $this->key,
                'template' => $this->template,
            ]);
        }
        return view($this->render . __function__)->with([
            'fields'   => Helper::ListData($this->model->datatable),
            'template' => $this->template,
        ]);
    }

    public function update()
    {
        $id = request()->get('code');
        if (!empty($id)) {
            $single = $this->model->baca($id)->get()->first();
            if (!empty($single)) {
                $detail = $this->model->getDetail($single->email)->get();
            } else {
                $detail = null;
            }

            return view($this->render . __function__)->with([
                'template' => $this->template,
                'model'     => $single,
                'detail'   => $detail,
                'user'     => $this->model->baca()->get(),
                'key'      => $this->key,
            ]);
        } else {
            if (request()->isMethod('POST')) {
                $id       = collect(request()->query())->flip()->first();
                $update   = request()->all();
                $password = request()->get('pwd');
                if (!empty($password)) {
                    $this->model->update_password($id, $password);
                }
                $this->model->ubah($id, request()->all());

                if (request()->exists('team')) {
                    $team = request()->get('team');
                    $this->model->filter(request()->get('email'), $team);
                }
            }
            return redirect()->back();
        }
    }

    public function delete()
    {
        $data = request()->all();
        foreach ($data['id'] as $d) {
            $this->model->active($d, 0);
        }

        return redirect()->back();
    }

}
