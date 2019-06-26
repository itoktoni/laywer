<?php
namespace App;

use Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    protected $table      = 'contact';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id',
        'name',
        'email',
        'phone',
        'company',
        'message',
        'created_at',
        'updated_at',
    ];
    public $datatable = [
        'id'            => [false => 'ID'],
        'name'          => [true => 'Name'],
        'email'          => [true => 'Email'],
        'phone'          => [true => 'Phone'],
        'company'          => [true => 'Company'],
        'message'          => [true => 'Message'],
    ];
    public $searching    = 'name';
    public $timestamps   = true;
    public $incrementing = true;
    public $rules        = [
        'name' => 'required|min:3',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected function generateKey()
    {
        $autonumber = 'C' . date('Y') . date('m');
        return Helper::code($this->table, $this->primaryKey, $autonumber, config('website.autonumber'));
    }

    public function simpan($request)
    {
        try
        {
            if (!$this->incrementing) {
                $code                       = $this->generateKey();
                $request[$this->primaryKey] = $code;
            }

            if (!empty($request['images'])) {
                $file                      = request()->file('images');
                $ext                       = $file->extension();
                $name                      = Helper::unic(10) . '.' .$ext; 
                $request['images'] = $name;
                $simpen                    = $file->storeAs('slider', $name);
            }

            $activity = $this->create($request);
            if ($activity->save()) {
                // session()->put('success', 'Data Has Been Added !');
                return true;
            }
        } catch (\Illuminate\Database\QueryException $ex) {

            // session()->put('danger', $ex->getMessage());
        }
    }

    public function hapus($data)
    {
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

    public function ubah($id, $request)
    {
        try
        {
            if (!empty($request['images'])) {
                $file                      = request()->file('images');
                $ext                       = $file->extension();
                $name                      = Helper::unic(10) . '.' .$ext; 
                $request['images'] = $name;
                $simpen                    = $file->storeAs('slider', $name);
            }

            $activity = $this->find($id)->update($request);
            if ($activity) {
                session()->put('success', 'Data Has Been Updated !');
            }

            return $activity;
        } catch (\Illuminate\Database\QueryException $ex) {
            session()->flash('alert-danger', $ex->getMessage());
        }
    }

    public function baca($id = null)
    {
        if (!empty($id)) {
            return $this->find($id);
        } 

        $model = $this->select();
        return $model;
    }
}
