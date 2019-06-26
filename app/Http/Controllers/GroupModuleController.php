<?php
namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use DataTables;
use Helper;

class GroupModuleController extends Controller{

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
        $this->model = new \App\GroupModule();
        $this->table = $this->model->getTable();
        $this->key = $this->model->getKeyName();
        $this->field = $this->model->getFillable();
        $this->searching = $this->model->searching;
        $this->rules = $this->model->rules;
        $this->datatable = $this->model->datatable;
        $this->template  = $this->getTemplate();
        $this->render    = 'page.' . $this->template . '.';
    }

    public function index()
    {
        return redirect()->route($this->getModule() . 'list');
    }

    public function create()
    {
        if(request()->isMethod('POST'))
        {
            $this->validate(request(), $this->rules);
            $request = request()->all();
            $this->model->simpan($request);
        }

        return view($this->render . __function__)->with('template', $this->template);
    }

    public function list()
    {
        if(request()->isMethod('POST'))
        {
            $getData   = $this->model->baca();
            $datatable = Datatables::of($this->filter($getData));
            $datatable->editColumn('checkbox', function ($select) {
                return Helper::createCheckbox($select->{$this->key});
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
        if(request()->has('code'))
        {
            $id = request()->get('code');
            $data = $this->model->baca($id);

            return view($this->render . '.show')->with(['fields' => $this->datatable,
                            'data' => $this->validasi($data),
                            'key' => $this->key,
                            'template' => $this->template]);
        }

        return view($this->render . __function__)->with(['fields' => $this->datatable,
                        'template' => $this->template]);
    }

    public function update()
    {
        $id = request()->get('code');
        if(!empty($id))
        {
            $getData = $this->model->baca($id);
            return view($this->render . __function__)->with([
                            'template' => $this->template,
                            'data' => $this->validasi($getData),
                            'key' => $this->key
            ]);
        }
        else
        {
            if(request()->isMethod('POST'))
            {
                $id = collect(request()->query())->flip()->first();
                $requestData = request()->all();
                $this->model->ubah($id, $requestData);
            }
            return redirect()->back();
        }
    }

    public function delete()
    {
        $input = request()->all();
        $this->model->hapus($input);

        return redirect()->back();
    }

}
