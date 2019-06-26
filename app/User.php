<?php
namespace App;

use Helper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'users'; //nama table
    protected $primaryKey = 'user_id'; //nama primary key
    protected $fillable    = [
        'user_id',
        'nik',
        'name',
        'email',
        'password',
        'username',
        'photo',
        'active',
        'group_user',
        'remember_token',
        'created_at',
        'updated_at',
        'warehouse',
        'site_id',
        'target',
        'pencapaian',
        'gender',
        'address',
        'birth',
        'place_birth',
        'biografi',
        'handphone',
        'no_tax',
        'created_by',
        'sales_responsible',
    ];
    public $searching     = 'name'; //default pencarian ketika di cari
    public $timestamps    = true; //kalau mau automatic update tanggal
    public $incrementing  = false; //kalau id nya mau dibuatkan otomatis
    public $rules         = [ //validasi https://laravel.com/docs/5.5/validation
        'user_name'  => 'required|min:3',
        'email'      => 'required|email',
        'group_user' => 'required',
        'password'   => 'required',
    ];

    public $datatable = [
        'user_id'    => [true => 'ID User'],
        'name'       => [true => 'Name'],
        'email'      => [true => 'Email'],
        'group_user' => [true => 'Group User'],
        'active'     => [true => 'Active'],
    ];
    public $list;
    public static $autonumber;
    public $status = [
        '1' => [ 'Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function generateKey()
    {
        $autonumber = 'C' . date('Y') . date('m');
        return Helper::code($this->table, $this->primaryKey, $autonumber, config('website.autonumber'));
    }

    public static function boot()
    {
        static::saving(function ($table) {
            $table->active     = 0;
            $table->created_by = Auth::user()->username;
        });
    }

    public function simpan($request)
    {
        try
        {
            if (!$this->incrementing) {
                $code                       = $this->generateKey();
                $request[$this->primaryKey] = $code;
            }

            $request['password'] = bcrypt($request['password']);
            $activity            = $this->create($request);
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

    public function filter($id, $data)
    {
        try
        {
            $filter = DB::table('filters');
            $filter->where('key', '=', $id . '')->delete();

            foreach ($data as $d) {

                $filter->insert([
                    'key'   => $id . '',
                    'value' => $d . '',
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            session()->put('danger', $e->getMessage());
        }
    }

    public function filterSingle($id, $data)
    {
        try
        {
            $filter = DB::table('filters');
            $filter->where('key', '=', $id . '')->delete();
            $filter->insert(['key' => $id . '', 'value' => $data]);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->put('danger', $e->getMessage());
        }
    }

    public function ubah($id, $data, $photo = null)
    {
        try
        {
            $user = User::find($id);
            if (!empty($photo)) {
                $name        = auth()->user()->username . '.' . $photo->extension();
                $simpen      = $photo->storeAs('profile', $name);
                $user->photo = $name;
            }
            $user->active = '1';
            $user->update($data);
            session()->put('success', 'Data Has Been Updated !');
        } catch (\Illuminate\Database\QueryException $e) {
            session()->put('danger', $e->getMessage());
        }
    }

    public function getDetail($id)
    {
        $select = $this->select();
        $select->leftjoin('filters', 'filters.value', '=', 'users.email');
        $select->where('key', $id);
        return $select;
    }

    public function getUserByGroupUser($id = null)
    {
        $select = $this->select();
        if (!empty($id)) {
            $select->where('group_user', $id);
        } else {
            $select->select($this->fillable);
        }

        return $select;
    }

    public function baca($id = null)
    {
        if (!empty($id)) {
            $data = $this->find($id);
            return $data;
        }

        $list  = Helper::listData($this->datatable)->keys()->all();
        $model = $this->select($list);
        return $model;
    }

    public function update_password($key_id, $password)
    {
        $user = User::find($key_id)->update(['password' => bcrypt($password)]) ? true : false;
        return $user;
    }

    public function active($key_id, $value)
    {
        try
        {
            $user = User::find($key_id)->update(['active' => $value]);
            session()->flash('alert-success', 'Data Has Been Deleted !');
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('alert-danger', $e->getMessage());
        }
    }

}
