<?php

namespace App\Http\Livewire\UserManagement;

use Spatie\Permission\Models\Permission as UserPermission;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class Permission extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'created_at';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $name, $title, $guard_name = 'web', $module, $description;    
    
    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules() {
        return [
            'name' => ['required'],    
            'guard_name' => ['required'],
            'title' => ['nullable'],            
            'module' => ['nullable'],
            'description' => ['nullable'],                    
        ];
    }

    public function resetInputs()
    {
       $this->guard_name = 'web';
       $this->description = '';
       $this->module = '';
       $this->name = '';
       $this->title = '';       
       $this->selected_id = '';
       $this->deleteId = '';       
    }

    public function render()
    {        
    	return view('livewire.user-management.permission', [
            'permissions' => UserPermission::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');        
    }

    public function store() {             
        $this->validate();        
        try {      
            $data = [
                'guard_name' => $this->guard_name,
                'description' => $this->description,
                'module' => $this->module,
                'name' => $this->name,
                'title' => $this->title,
            ];
            DB::beginTransaction();            
            $cr = UserPermission::create($data);
            DB::commit();                      
            $this->resetInputs();
            $this->emit('permissionCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('permissionFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit($id)
    {   
        $grading = UserPermission::where('id', $id)->first();
        $this->selected_id = $id;
        $this->guard_name = $grading->guard_name;    
        $this->description = $grading->description;  
        $this->module = $grading->module;       
        $this->name = $grading->name;      
        $this->title = $grading->title;      
    }

    public function update()
    {
        $this->validate();
        if($this->selected_id) {
            $act = UserPermission::find($this->selected_id);
            try {
                DB::beginTransaction();
                $act->update([
                    'guard_name' => $this->guard_name,     
                    'description' => $this->description,    
                    'module' => $this->module,
                    'name' => $this->name,     
                    'title' => $this->title,                             
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('permissionUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('permissionFailed', $e->getMessage());
                return $e->getMessage();
            }
        }
    }

    public function deleteThisId($id)
    {
        $this->deleteId = $id;
    }
    
    public function deleteNow()
    {
        $role = UserPermission::where('id', $this->deleteId)->delete();
        $this->resetInputs();
        $this->emit('permissionDeleted');        
    }
    
}
