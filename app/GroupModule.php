<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class GroupModule extends Model{

    protected $table = 'group_modules';
    protected $primaryKey = 'group_module_code';
    protected $fillable = [
            'group_module_code',
            'group_module_name',
            'group_module_link',
            'group_module_sort',
            'group_module_visible',
            'group_module_enable',
            'group_module_description',
    ];
    
    public $searching = 'group_module_name';
    public $timestamps = false;
    public $incrementing = false;
    public $rules = [
            'group_module_code' => 'required|min:3|unique:group_modules',
            'group_module_name' => 'required|min:3',
    ];
    public $datatable = [
            'group_module_code' => 'Code',
            'group_module_name' => 'Name',
            'group_module_link' => 'Link',
            'group_module_description' => 'Description',
    ];
    
    public function getGroupByModule($module)
    {
        $select = DB::table($this->table);
        $select->join('group_module_connection_module', 'group_modules.group_module_code', '=', 'group_module_connection_module.conn_gm_group_module');
        $select->where('conn_gm_module', $module);

        return $select;
    }
    
    public function getGroupByUser($user)
    {
        $select = DB::table($this->table);
        $select->join('group_user_connection_group_module', 'group_modules.group_module_code', '=', 'group_user_connection_group_module.conn_gu_group_module');
        $select->where('conn_gu_group_user', $user);

        return $select;
    }

    // ========================================================================== 

    public function simpan($data)
    {
        try
        {
            $model = new static($data);
            $check = $model->save();
            return $check;
            session()->put('success', 'Data Has Been Added !');
        }
        catch(\Illuminate\Database\QueryException $ex)
        {
            session()->put('danger', $ex->getMessage());
        }
    }

    public function hapus($data)
    {
        if(!empty($data))
        {
            $data = collect($data)->flatten()->all();
            try
            {
                $this->Destroy($data);
                session()->flash('alert-success', 'Data Has Been Deleted !');
            }
            catch(\Illuminate\Database\QueryException $ex)
            {
                session()->flash('alert-danger', $ex->getMessage());
            }
        }
    }

    public function ubah($id, $data)
    {
        try
        {
            $s = $this->find($id);
            $s->update($data);
            return $s;
            session()->put('success', 'Data Has Been Updated !');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            session()->flash('alert-danger', $e->getMessage());
        }
    }

    public function baca($id = null)
    {
        if(!empty($id))
        {
            return $this->find($id);
        }
        
        return $this->select();
        
    }

}
