<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Helper;

class GroupUser extends Model
{

    protected $table      = 'group_users';
    protected $primaryKey = 'group_user_code';
    protected $fillable = [
        'group_user_code',
        'group_user_name',
        'group_user_description',
        'group_user_visible',
        'group_user_level',
        'group_user_dashboard',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
    public $searching    = 'group_user_name';
    public $timestamps   = false;
    public $incrementing = false;
    public $rules        = [
        'group_user_code' => 'required|min:3|unique:group_users',
        'group_user_name' => 'required|min:3',
    ];
    public $datatable = [
        'group_user_code'        => [true => 'Code'],
        'group_user_name'        => [true => 'Name'],
        'group_user_dashboard'   => [true => 'Dashboard'],
        'group_user_description' => [true => 'Description'],
    ];

    public $list;

    public function simpan($request)
    {
        try
        {
            if (!$this->incrementing) {
                $code                       = $this->generateKey();
                $request[$this->primaryKey] = $code;
            }
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

    public function baca($id = null)
    {
        if (!empty($id)) {
            $data = $this->find($id);
            return $data;
        }

        $model = $this->select(Helper::fields($this->datatable));
        return $model;
    }

    public function saveUser($code, $data)
    {
        try
        {
            if (!empty($data)) {
                DB::table('users')->where('group_user', $code)->update(['group_user' => null]);
                foreach ($data as $user) {
                    DB::table('users')->where('user_id', $user)->update(['group_user' => $code]);
                }
            }

            session()->put('success', 'Data Has Been Saved !');
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('alert-danger', $e->getMessage());
        }
    }

    public function saveKoneksiModule($code, $data)
    {
        try
        {
            DB::table('group_user_connection_group_module')->where('conn_gu_group_user', '=', $code)->delete();
            if (!empty($data)) {
                foreach ($data as $d) {
                    DB::table('group_user_connection_group_module')->insert([
                        'conn_gu_group_module' => $d,
                        'conn_gu_group_user'   => $code,
                    ]);
                }
            }

            session()->put('success', 'Data Has Been Saved !');
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('alert-danger', $e->getMessage());
        }
    }

}
