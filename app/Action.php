<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Action extends Model{

    protected $table = 'actions';
    protected $primaryKey = 'action_code';
    protected $fillable = [
            'action_code',
            'action_name',
            'action_description',
            'action_link',
            'action_controller',
            'action_function',
            'action_sort',
            'action_enable',
            'action_visible',
    ];
    
    public $searching = 'action_name';
    public $timestamps = false;
    public $incrementing = false;
    public $rules = [
            'action_name' => 'required|min:3',
    ];
    public $datatable = [
            'action_code' => 'Code',
            'action_name' => 'Name',
            'action_link' => 'Link',
            'action_controller' => 'Controller',
            'action_function' => 'Function',
            'action_enable' => 'Enable',
            'action_visible' => 'Visible',
    ];
    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];

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
                session()->flash('alert-danger', $e->getMessage());
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
        catch(\Illuminate\Database\QueryException $ex)
        {
            session()->flash('alert-danger', $ex->getMessage());
        }
    }

   public function baca($id = null)
    {
        if (!empty($id)) {
            $data = $this->find($id);
            return $data;
        }

        $list = collect($this->datatable)->keys()->all();
        $model = $this->select($list);
        return $model;
    }


    public function active($key_id, $value)
    {
        try
        {
            $user = Action::find($key_id)->update(['action_visible' => $value]);
            session()->flash('alert-success', 'Data Has Been Deleted !');
        }
        catch(\Illuminate\Database\QueryException $ex)
        {
            session()->flash('alert-danger', $ex->getMessage());
        }
    }

}
