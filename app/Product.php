<?php

namespace App;

use Auth;
use Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Product extends Model {
	protected $table = 'products'; //nama table
	protected $primaryKey = 'id'; //nama primary key
	protected $guarded = [];
	protected $fillable = [
		'id',
		'name',
		'images',
		'price',
		'slug',
		'description',
		'category_id',
		'tags',
		'active',
		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];
	public $datatable = [
		'id' => [false => 'ID product'],
		'name' => [true => 'Name'],
		'price' => [true => 'Harga Jual'],
		'active' => [true => 'Active'],
	];
	public $searching = 'name'; //default pencarian ketika di cari
	public $timestamps = true; //kalau mau automatic update tanggal
	public $incrementing = true; //kalau id nya mau dibuatkan otomatis
	public $rules = [ //validasi https://laravel.com/docs/5.5/validation
		'name' => 'required|min:3',
		'price' => 'numeric',
	];
	public $list;
	public static $autonumber;

	public $status = [
		'0' => ['NOT ACTIVE', 'danger'],
		'1' => ['ACTIVE', 'success'],
	];

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $dates = [
		'created_at',
		'updated_at',
	];

	protected function generateKey() {
		$autonumber = 'C' . date('Y') . date('m');
		return Helper::code($this->table, $this->primaryKey, $autonumber, config('website.autonumber'));
	}

	public static function boot() {
		static::updating(function ($table) {
			$table->updated_by = Auth::user()->username;
		});

		static::saving(function ($table) {
			$table->created_by = Auth::user()->username;
		});
	}

	public function simpan($request) {
		try
		{
			if (!$this->incrementing) {
				$code = $this->generateKey();
				$request[$this->primaryKey] = $code;
			}

			if (!empty($request['images'])) {
				$file = request()->file('images');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['images'] = $name;
				$simpen = $file->storeAs('product', $name);
			}
			if(isset($request['tags'])){
				$request['tags'] = json_encode($request['tags']);
			}
			$request['slug'] = str_slug($request['name']);
			$activity = $this->create($request);
			if ($activity->save()) {

				session()->put('success', 'Data Has Been Added !');
				return true;
			}

			session()->put('danger', 'Data Failed To Save !');
			return false;

		} catch (\Illuminate\Database\QueryException $ex) {
			session()->put('danger', $ex->getMessage());
			return false;
		}
	}

	public function hapus($data) {
		if (!empty($data)) {
			$data = collect($data)->flatten()->all();
			try
			{
				$activity = $this->Destroy($data);
				if ($activity) {
					session()->put('success', 'Data Has Been Deleted !');
					return true;
				}
				session()->flash('alert-danger', 'Data Can not Deleted !');
				return false;
			} catch (\Illuminate\Database\QueryException $ex) {
				session()->flash('alert-danger', $ex->getMessage());
			}
		}
	}

	public function ubah($id, $request) {
		try
		{
			if (!empty($request['images'])) {
				$file = request()->file('images');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['images'] = $name;
				$simpen = $file->storeAs('product', $name);
			}

			if(isset($request['tags'])){
				$request['tags'] = json_encode($request['tags']);
			}
			$request['slug'] = str_slug($request['name']);
			$activity = $this->find($id)->update($request);
			if ($activity) {
				session()->put('success', 'Data Has Been Updated !');
			}

			return $activity;

		} catch (\Illuminate\Database\QueryException $ex) {
			session()->put('danger', $ex->getMessage());
			return false;
		}
	}

	public function baca($id = null) {
		if (!empty($id)) {
			$data = $this->find($id);
			return $data;
		}

		$model = $this->select();
		return $model;
	}

}
