<?php

namespace App\Helpers;

use Cache;
use Curl;
use DB;
use File;
use Route;
use Thedevsaddam\LaravelSchema\Schema\Schema as Table;

class Helper {

	public static function base_url() {

		return sprintf(
			"%s://%s%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME'],
			$_SERVER['REQUEST_URI']
		);

		// return asset('');

	}
	public static function access() {

		$split = explode('/', Route::current()->uri);
		$access = $split[0];
		return $access;
	}
	public static function secure() {
		return isset($_SERVER['HTTPS']) ? 'http' : 'https';
	}

	public static function asset($path) {
		$public = config('website.public');
		if (config('website.env') == 'dev') {
			$public = '';
		}
		return asset($public . $path, isset($_SERVER['HTTPS']));
	}

	public static function frontend($path) {
		return self::asset('/frontend/' . config('website.frontend') . '/' . $path);
	}

	public static function backend($path) {
		return self::asset('/backend/' . config('website.backend') . '/' . $path);
	}

	public static function credential($path) {
		return self::asset('/credential/' . $path);
	}

	public static function files($path) {
		return self::asset('/files/' . $path);
	}

	public static function vendor($path) {
		return self::asset('/vendor/' . $path);
	}

	public static function unic($length) {
		$chars = array_merge(range('a', 'z'), range('A', 'Z'));
		$length = intval($length) > 0 ? intval($length) : 16;
		$max = count($chars) - 1;
		$str = "";

		while ($length--) {
			shuffle($chars);
			$rand = mt_rand(0, $max);
			$str .= $chars[$rand];
		}

		return $str;
	}

	public static function Code($tablename, $fieldid, $prefix, $codelength) {
		$db = DB::table($tablename);
		$db->select(DB::raw('max(' . $fieldid . ') as maxcode'));
		$db->where($fieldid, "like", "$prefix%");

		$ambil = $db->first();
		$data = $ambil->maxcode;

		if ($db->count() > 0) {
			$code = substr($data, strlen($prefix));
			$countcode = ($code) + 1;
		} else {
			$countcode = 1;
		}
		$newcode = $prefix . str_pad($countcode, $codelength - strlen($prefix), "0", STR_PAD_LEFT);
		return $newcode;
	}

	public static function getClass($class) {
		return (new \ReflectionClass($class))->getShortName();
	}

	public static function label($data) {
		$controller = Route::current()->getController();
		$table = $controller->model->getTable();
		$datatable = $controller->model->datatable;
		$field = $controller->model->getFillable();
		// $list = [];
		// foreach ($field as $value) {

		//     $split = explode('_', $value);
		//     if (count($split) > 1) {
		//         $nama = ucwords(str_replace('_', ' ', $value));
		//     } else {
		//         $nama = ucwords($value);
		//     }

		//     $clean    = str_replace('Id', 'Code', $nama);
		//     $list[$value] = [false => $clean];
		// }

		// if (!empty($datatable)) {
		//     $field = array_merge($field, $datatable);
		// }

		if (array_key_exists($data, $datatable)) {
			return key(array_flip($datatable[$data]));
		}

		return ucwords(str_replace('_', ' ', $data));
	}

	public static function listData($datatable) {
		$collection = collect($datatable);
		$filtered = $collection->filter(function ($value, $key) {
			if (array_key_exists('1', $value)) {
				return $value[1];
			}
		});

		$collection = collect($filtered->all());
		$list_data = $collection->mapWithKeys(function ($value, $key) {
			return [$key => $value[1]];
		});

		return $list_data;
	}

	public static function masterCheckbox($template = null) {
		if (!empty($template)) {
			return 'page.' . $template . '.checkbox';
		}
		return 'page.master.checkbox';
	}

	public static function masterAction($template = null) {
		if (!empty($template)) {
			return 'page.' . $template . '.action';
		}
		return 'page.master.action';
	}

	public static function createCheckbox($id) {

		return '<input type="checkbox" name="id[]" value="' . $id . '">';
	}

	public static function shareStatus($data) {
		$status = collect($data)->map(function ($item, $key) {
			if (is_array($item)) {
				return $item[0];
			}
			return $item;
		});
		return $status->all();
	}

	public static function createStatus($data) {
		$value = $data['value'];
		$color = 'default';
		$label = 'Unknows';
		if (isset($data['status'][$value])) {
			if (is_array($data['status'][$value]) && !empty($data['status'][$value][1])) {

				$label = $data['status'][$value][0];
				$color = $data['status'][$value][1];
			} else {
				$label = $data['status'][$value];
				$color = 'default';
			}
		}
		return '<span class="btn btn-xs btn-block btn-' . $color . '">' . $label . '</span>';
	}

	public static function createSort($data) {

		$class = "form-control input-sm text-center";
		$aksi = '<input type="hidden" name="kode[]" value="' . $data['hidden'] . '">';
		$aksi = $aksi . '<input type="text" name="order[]" class="' . $class . '" value="' . $data['value'] . '">';
		return $aksi;
	}

	public static function createAction($data) {

		$aksi = '<div class="aksi text-center">';
		$id = $data['key'];

		foreach ($data['action'] as $key => $value) {
			$action = isset($value[1]) ? $value[1] : $key;
			$route = route($data['route'] . '_' . $key, ['code' => $id]);
			$aksi = $aksi . '<a href="' . $route . '" class="btn btn-xs btn-' . $value[0] . '">' . $action . '</a> ';
		}

		return $aksi . '</div>';
	}

	public static function createOption($route, $cache = false) {
		// if (!empty(Cache::get($route)) && Cache::has($route)) {
		// 	return Cache::get($route);
		// }
		$collect = [];
		if ($cache) {
			$parse = Curl::to(route($route))->post();
			$json = json_decode($parse);
			$collect = collect($json->data);
			Cache::put($route, $collect, config('website.cache'));
		}
		return $collect;
	}

	public static function getTable($table = null) {
		if (Cache::has('tables')) {
			$arrayTable = Cache::get('tables');
			if (empty($table)) {
				return $arrayTable;
			}
			return $arrayTable[$table];
		}

		return \Schema::getColumnListing($table);
	}

	public static function getTranslate($table, $merge = null) {
		dd($merge);
		$column = self::getTable($table);
		// dd($column);
		$data = [];
		foreach ($column as $key => $value) {

			$split = explode('_', $value);
			if (count($split) > 1) {
				$nama = ucwords(str_replace('_', ' ', $value));
			} else {
				$nama = ucwords($value);
			}

			$clean_id = str_replace('Id', '', $nama);
			$clean_table = str_replace(ucwords($table), '', $clean_id);
			if (ctype_space($clean_table)) {
				$clean_table = 'Code';
			}
			$data[$value] = [false => $clean_table];
		}

		if (!empty($merge)) {
			$data = array_merge($data, $merge);
		}
		return $data;
	}

	public static function fields($data) {
		$fields = self::listData($data);
		return $fields->keys()->all();
	}

	public static function checkJson($id, $data) {

		$status = false;
		if (!empty($data)) {
			$arr = json_decode($data);
			if (is_array($data) && in_array($id, $arr)) {
				$status = true;
			} else if ($id == $arr) {

				$status = true;
			}
		}

		return $status;
	}

	public static function extension($data) {

		return File::extension($data);
	}

	public static function ext($data) {

		$icon = self::extension($data);
		$mapping = collect(config('icon'));
		$check = $mapping->has($icon);
		return $check ? config('icon.' . $icon) : 'file';
	}

	public static function mode($data) {

		$icon = self::extension($data);
		$mapping = collect(config('ext'));
		$check = $mapping->has($icon);
		return $check ? config('ext.' . $icon) : 'txt';
	}

}
