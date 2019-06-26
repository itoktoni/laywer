<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model {

	protected $table = 'modules';
	protected $primaryKey = 'module_code';
	protected $fillable = [
		'module_code',
		'module_name',
		'module_description',
		'module_link',
		'module_controller',
		'module_filters',
		'module_sort',
		'module_visible',
		'module_enable',
	];
	public $searching = 'module_name';
	public $incrementing = false;
	public $timestamps = false;
	public $rules = [
		'module_code' => 'required|unique:modules|min:3',
		'module_name' => 'required|min:3',
		'module_controller' => 'required|min:3',
	];
	public $datatable = [
		'module_code' => 'Code',
		'module_name' => 'Name',
		'module_controller' => 'Controller',
		'module_description' => 'All List Module Description',
	];

	public function simpan($data) {
		try
		{
			$data['module_sort'] = !empty(request()->get('module_sort')) ? request()->get('module_sort') : 1;
			$this->Create($data);
			session()->put('success', 'Data Has Been Added !');
		} catch (\Illuminate\Database\QueryException $e) {
			session()->put('danger', $e->getMessage());
		}
	}

	public function ubah($id, $data) {
		try
		{
			$s = $this->find($id);
			if (!empty($data['filter'])) {
				$gabung = collect($data['filter'])->implode(',');
				$s['module_filters'] = $gabung;
			} else {
				$s['module_filters'] = null;
			}
			$s->update($data);
			session()->put('success', 'Data Has Been Updated !');
		} catch (\Illuminate\Database\QueryException $e) {
			session()->flash('alert-danger', $e->getMessage());
		}
	}

	public function baca($id = null) {
		if (!empty($id)) {
			return $this->find($id);
		} else {
			return $this->select();
		}
	}

	public function getModule($id) {
		$select = DB::table($this->table);
		$select->join('module_connection_action', 'modules.module_code', '=', 'module_connection_action.conn_ma_module');
		$select->join('actions', 'actions.action_code', '=', 'module_connection_action.conn_ma_action');
		$select->where('module_code', $id);

		return $select;
	}

	public function saveGroupModule($code, $data) {
		try
		{
			$cek = DB::table('group_module_connection_module')->where('conn_gm_module', '=', $code)->delete();
			if (!empty(request()->get('group'))) {
				foreach ($data as $group) {
					$select = DB::table('group_module_connection_module');
					$select->where('conn_gm_group_module', '=', $group);
					$select->where('conn_gm_module', '=', $code);
					$select->get();
					if ($select->Count() > 0) {

					} else {
						DB::table('group_module_connection_module')->insert([
							'conn_gm_group_module' => $group,
							'conn_gm_module' => $code,
						]);
					}
				}
			}

			session()->put('success', 'Data Has Been Saved !');
		} catch (\Illuminate\Database\QueryException $e) {
			session()->flash('alert-danger', $e->getMessage());
		}
	}

	public function saveConnectionAction($data) {
		$code = $data['module_code'];
		$controller = $data['module_controller'];
		$name = $data['module_name'];
		$act = $data['act'];

		if (!empty($data)) {
			try
			{
				if (!empty($data['act'])) {

					DB::table('actions')->where('action_code', 'like', "$code%")->delete();

					foreach ($data['act'] as $d) {
						$enable = '0';
						if ($d == 'create' || $d == 'list' || $d == 'read') {
							$enable = '1';
						}

						$split = explode('_', $d);
						$nama = ucwords(str_replace('_', ' ', $d)) . ' ' . $name;
						if (count($split) > 1) {
							$nama = ucwords(str_replace('_', ' ', $d));
						}

						DB::table('actions')->insert([
							'action_code' => $code . '_' . $d,
							'action_module' => $code,
							'action_name' => $nama,
							'action_link' => $code . '/' . $d,
							'action_controller' => $controller,
							'action_function' => $d,
							'action_sort' => 0,
							'action_visible' => $enable,
							'action_enable' => '1',
						]);
					}
				}

				DB::table('module_connection_action')->where('conn_ma_module', '=', $code)->delete();
				if (!empty($data['actions'])) {
					foreach ($data['actions'] as $d) {
						$enable = '0';
						if ($d == 'create' || $d == 'read') {
							$enable = '1';
						}

						DB::table('module_connection_action')->insert([
							'conn_ma_module' => $code,
							'conn_ma_action' => $code . '_' . $d,
						]);
					}
				}

				session()->put('success', 'Data Has Been Saved !');
			} catch (\Illuminate\Database\QueryException $e) {
				session()->flash('alert-danger', $e->getMessage());
			}
		}
	}

	public function saveSort($code, $order) {
		try
		{
			$data = DB::table($this->table)->where($this->primaryKey, $code)->update(['module_sort' => $order]);
			session()->put('success', 'Data Has Been Updated !');
		} catch (\Illuminate\Database\QueryException $e) {
			session()->flash('alert-danger', $e->getMessage());
		}
	}

	public function hapus($code) {
		if (!empty($code)) {
			try
			{
				DB::table('actions')->where('action_code', 'like', "$code%")->delete();
				DB::table('module_connection_action')->where('conn_ma_module', '=', $code)->delete();
				DB::table('group_module_connection_module')->where('conn_gm_module', '=', $code)->delete();
				DB::table($this->table)->where($this->primaryKey, '=', $code)->delete();

				session()->flash('alert-success', 'Data Has Been Deleted !');
			} catch (\Illuminate\Database\QueryException $e) {
				session()->flash('alert-danger', $e->getMessage());
			}
		}
	}
}
