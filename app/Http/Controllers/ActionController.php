<?php

namespace App\Http\Controllers;

use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use DataTables;
class ActionController extends Controller
{
    public $table;
    public $key;
    public $field;
    public $model;
    public $template;
    public $rules;
    public $datatable;
    public $searching;
    public $read;
    public $render;

    public function __construct()
    {
        $this->model     = new \App\Action();
        $this->table     = $this->model->getTable();
        $this->key       = $this->model->getKeyName();
        $this->field     = $this->model->getFillable();
        $this->datatable = $this->model->datatable;
        $this->rules     = $this->model->rules;
        $this->searching = $this->model->searching;
        $this->template  = $this->getTemplate();
        $this->render    = 'page.' . $this->template . '.';
    }

    public function index()
    {
        return redirect()->route($this->getModule() . 'list');
    }

    public function create()
    {
        if (request()->isMethod('POST')) {
            $this->validate(request(), $this->rules);
            $request = request()->all();
            $this->model->simpan($request);
        }

        return view($this->render . __function__)
            ->with('template', $this->template);
    }

    function list() {
        if (request()->isMethod('POST')) {
            $getData   = $this->model->baca();
            $datatable = Datatables::of($this->filter($getData));
            $datatable->editColumn('checkbox', function ($select) {
                return Helper::createCheckbox($select->{$this->key});
            });

             $datatable->editColumn('action_visible', function ($select) {
                return Helper::createStatus([
                    'value'   => $select->action_visible,
                    'status'  => $this->model->status,
                ]);
            });

            $datatable->editColumn('action_enable', function ($select) {
                return Helper::createStatus([
                    'value'    => $select->action_enable,
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
            $datatable->rawColumns([
                'action_visible','action_enable', 'checkbox','action'
            ]);
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
            $id   = request()->get('code');
            $data = $this->model->baca($id);

            return view('page.' . $this->template . '.show')->with([
                'fields'   => $this->datatable,
                'data'     => $this->validasi($data),
                'key'      => $this->key,
                'template' => $this->template,
            ]);
        }

        return view($this->render . __function__)->with([
            'fields'   => $this->datatable,
            'template' => $this->template,
        ]);
    }

    public function update()
    {
        $id = request()->get('code');
        if (!empty($id)) {
            $getData = $this->model->baca($id);
            return view($this->render . __function__)->with([
                'template' => $this->template,
                'data'     => $this->validasi($getData),
                'key'      => $this->key,
            ]);
        } else {
            if (request()->isMethod('POST')) {
                $id          = collect(request()->query())->flip()->first();
                $requestData = request()->all();
                $this->model->ubah($id, $requestData);
            }
            return redirect()->back();
        }
    }

    public function delete()
    {
        $data = request()->all();
        foreach ($data['id'] as $d) {
            $this->model->active($d, '0');
        }

        return redirect()->back();
    }

}
