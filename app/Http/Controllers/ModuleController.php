<?php
namespace App\Http\Controllers;

use DataTables;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ModuleController extends Controller {

	public $table;
	public $key;
	public $field;
	public $model;
	public $template;
	public $rules;
	public $datatable;
	public $searching;
	public $render;

	public function __construct() {
		$this->model = new \App\Module();
		$this->table = $this->model->getTable();
		$this->key = $this->model->getKeyName();
		$this->field = $this->model->getFillable();
		$this->datatable = $this->model->datatable;
		$this->rules = $this->model->rules;
		$this->searching = $this->model->searching;
		$this->template = $this->getTemplate();
		$this->render = 'page.' . $this->template . '.';

	}

	private function index() {
		return redirect()->route($this->getModule() . 'list');
	}

	public function create() {
		if (request()->isMethod('POST')) {
			$this->validate(request(), $this->rules);

			$data = request()->all();
			$code = request()->get('module_code');
			$data['module_link'] = $code;
			$this->model->simpan($data);

			return redirect()->route('module_update', ['code' => $code]);
		}

		return view($this->render . __function__)->with('template', $this->template);
	}

	public function list() {
		if (request()->isMethod('POST')) {
			$getData = $this->model->baca();
			$datatable = Datatables::of($this->filter($getData));
			$datatable->editColumn('checkbox', function ($select) {
				return Helper::createCheckbox($select->{$this->key});
			});
			$datatable->editColumn('order', function ($select) {
				return Helper::createSort([
					'hidden' => $select->module_code,
					'value' => $select->module_sort,
				]);
			});
			$datatable->addColumn('action', function ($select) {
				$action = [
					'update' => ['primary', 'edit'],
					'list' => ['success', 'show'],
				];

				if (!session()->exists('button')) {
					session()->put('button', count($action));
				}
				$data = Helper::createAction([
					'key' => $select->{$this->key},
					'route' => $this->getModule(),
					'action' => $action,
				]);
				return $data;
			});
			$datatable->rawColumns(['order', 'action', 'checkbox']);
			if (!empty(request()->get('search'))) {
				$datatable->filter(function ($query) {
					$code = request()->get('code');
					$search = request()->get('search');
					$aggregate = request()->get('aggregate');
					$search_field = empty($code) ? $this->model->searching : $code;
					$aggregation = empty($aggregate) ? 'like' : $aggregate;
					$input = empty($aggregate) ? "%$search%" : "$search";
					$query->where($search_field, $aggregation, $input);
				});
			}

			return $datatable->make(true);
		}

		if (request()->has('code')) {
			$id = request()->get('code');
			return view($this->render . '.show')->with([
				'fields' => $this->datatable,
				'data' => $this->validasi($this->model->baca($id)),
				'key' => $this->key,
				'template' => $this->template,
			]);
		}

		return view($this->render . __function__)->with(['fields' => $this->datatable,
			'template' => $this->template]);
	}

	public function update() {
		// dd(request()->all());
		$id = request()->get('code');
		if (!empty($id)) {
			$model = $this->validasi($this->model->baca($id));
			$controller = $model->module_controller;
			$group = new \App\GroupModule();
			$list_group = $group->getGroupByModule($id)->get();
			$user = new \App\User();
			$filter = $user->getFillable();
			$f = $model->module_filters;

			if (strpos($f, ',')) {
				$get = explode(',', $model->first()->module_filters);
			} else {
				$get = $f;
			}

			foreach ($this->getMethod($controller) as $c) {
				$act = DB::table('module_connection_action');
				$act->where('conn_ma_action', '=', $id . '_' . $c);
				$act->where('conn_ma_module', '=', $id);
				$act->get()->first();

				$status = false;
				if ($act->count() > 0) {
					$status = true;
				}
				$item[] = [
					'code' => $c,
					'status' => $status,
				];
			}

			return view($this->render . __function__)->with([
				'template' => $this->template,
				'data' => $model,
				'controller' => $controller,
				'group' => $list_group,
				'filter' => $filter,
				'detail' => $get,
				'fungsi' => $this->getMethod($controller),
				'act' => $item,
				'list' => $this->model->getModule($id)->get()->toArray(),
				'key' => $this->key,
			]);
		} else {
			if (request()->isMethod('POST')) {
				$id = collect(request()->query())->flip()->first();
				$requestData = request()->all();
				$this->model->ubah($id, $requestData);

				if (request()->exists('act')) {
					$this->model->saveConnectionAction($requestData);
				}

				$this->model->saveGroupModule($id, request()->get('group'));

			}
			return redirect()->route('module_list');
		}
	}

	public function delete() {
		$action = request()->get('action');
		if ($action == 'delete') {
			$code = request()->get('id');
			for ($i = 0; $i < count($code); $i++) {

				$kode = $code[$i];
				$getModule = $this->model->baca($kode)->first();
				// dd($getModule);
				// dd(app_path().'/app/Http/Controllers/'.$getModule->module_controller.'Controller.php');
				// \File::delete(app_path().'/app/Http/Controllers/'.$getModule->module_controller.'Controller.php');
				// \File::delete(app_path().'/app/Http/Controllers/'.$getModule->module_controller.'Controller.php');
				// \File::delete(app_path().'/app/Http/Controllers/'.$getModule->module_controller.'Controller.php');

				// dd($delete);
				$this->model->hapus($kode);
				// \File::delete(app_path().'/app/Http/Controllers/'.$getModule->module_code.'Controller.php');
			}
		}

		if ($action == 'sort') {
			$sort = request()->get('order');
			$kode = request()->get('kode');
			for ($i = 0; $i < count($sort); $i++) {

				$code = $kode[$i];
				$order = $sort[$i];
				$this->model->saveSort($code, $order);
			}
		}

		return redirect()->back();
	}

}
