<?php

namespace App;

use Helper;
use Illuminate\Database\Eloquent\Model;

class Perkara extends Model {

	protected $table = 'perkara';
	protected $primaryKey = 'no_berkas';
	protected $fillable = [
		'no_berkas',
		'name',
		'description',
		'created_at',
		'updated_at',
		'id_customer',
		'id_gedung',
		'id_ruangan',
		'id_rack',
		'id_jenis_perkara',
		'tag',
		'no_pengaduan',
		'no_pengajuan_kejaksaan',
		'id_user',
		'berkas_pemohon',
		'berkas_pengadilan',
		'berkas_laporan_polisi',
		'berkas_putus_pengadilan',
		'status',
		'slug',
	];
	public $datatable = [
		'no_berkas' => [true => 'No Berkas'],
		'name' => [true => 'Name'],
		'status' => [true => 'Status'],
		'description' => [true => 'Description'],
	];
	public $searching = 'name';
	public $timestamps = true;
	public $incrementing = false;
	public $rules = [
		'name' => 'required|min:3',
	];

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';

	protected $dates = [
		'created_at',
		'updated_at',
	];
	public $file;

	protected function generateKey() {
		$autonumber = 'C' . date('Y') . date('m');
		return Helper::code($this->table, $this->primaryKey, $autonumber, config('website.autonumber'));
	}

	public function simpan($request) {
		try {

			$code = $this->generateKey();
			$request[$this->primaryKey] = $code;

			if (!empty($request['tags'])) {
				$request['tag'] = json_encode(request()->get('tags'));
			}

			if (!empty($request['pemohon'])) {
				$file = request()->file('pemohon');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['berkas_pemohon'] = $name;
				$simpen = $file->storeAs('perkara', $name);
			}

			if (!empty($request['pengadilan'])) {
				$file = request()->file('pengadilan');
				dd($file);
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['berkas_pengadilan'] = $name;
				$simpen = $file->storeAs('perkara', $name);
			}

			if (!empty($request['polisi'])) {
				$file = request()->file('polisi');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['berkas_laporan_polisi'] = $name;
				$simpen = $file->storeAs('perkara', $name);
			}

			if (!empty($request['putusan'])) {
				$file = request()->file('putusan');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['berkas_putus_pengadilan'] = $name;
				$simpen = $file->storeAs('perkara', $name);
			}

			$request['slug'] = str_slug($request['name']);
			$activity = $this->create($request);

			if ($activity->save()) {
				session()->put('success', 'Data Has Been Added !');
				return true;
			}
		} catch (\Illuminate\Database\QueryException $ex) {

			session()->put('danger', $ex->getMessage());
		}
	}

	public function hapus($data) {
		if (!empty($data)) {
			$data = collect($data)->flatten()->all();
			try {
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
		try {

			if (!empty($request['tags'])) {
				$request['tag'] = json_encode(request()->get('tags'));
			}

			if (!empty($request['pemohon'])) {
				$file = request()->file('pemohon');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['berkas_pemohon'] = $name;
				$simpen = $file->storeAs('perkara', $name);

//                 $path = 'remote.php/webdav/';
				//                 $filesystem = Flysystem::connection('webdav');
				//                 try {

// //                    $response = $filesystem->createDir($path . '/' . $id);

//                     $stream = fopen($file->getRealPath(), 'r+');
				//                     $filesystem->writeStream($path .  $id . '/' . $file->getClientOriginalName(), $stream);
				//                     fclose($stream);
				//                 } catch (Exception $ex) {

//                 }
			}

			if (!empty($request['pengadilan'])) {
				$file = request()->file('pengadilan');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['berkas_pengadilan'] = $name;
				$simpen = $file->storeAs('perkara', $name);
			}

			if (!empty($request['polisi'])) {
				$file = request()->file('polisi');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['berkas_laporan_polisi'] = $name;
				$simpen = $file->storeAs('perkara', $name);
			}

			if (!empty($request['putusan'])) {
				$file = request()->file('putusan');
				$ext = $file->extension();
				$name = Helper::unic(10) . '.' . $ext;
				$request['berkas_putus_pengadilan'] = $name;
				$simpen = $file->storeAs('perkara', $name);
			}

			$request['slug'] = str_slug($request['name']);
			$activity = $this->find($id)->update($request);
			if ($activity) {
				session()->put('success', 'Data Has Been Updated !');
			}

			return $activity;
		} catch (\Illuminate\Database\QueryException $ex) {
			session()->flash('alert-danger', $ex->getMessage());
		}
	}

	public function baca($id = null) {
		if (!empty($id)) {
			return $this->find($id);
		}

		$model = $this->select();
		return $model;
	}

	public function Gedung() {
		return $this->hasOne('App\Gedung', 'id', 'id_gedung');
	}

	public function Ruangan() {
		return $this->hasOne('App\Ruangan', 'id', 'id_ruangan');
	}

	public function Rack() {
		return $this->hasOne('App\Rack', 'id', 'id_rack');
	}

	public function Perkara() {
		return $this->hasOne('App\Category', 'id', 'id_jenis_perkara');
	}

	public function Customer() {
		return $this->hasOne('App\Customer', 'id', 'id_customer');
	}

	public function Team() {
		return $this->hasOne('App\User', 'user_id', 'id_user');
	}

}
