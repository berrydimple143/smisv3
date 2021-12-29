<?php

namespace App\Http\Livewire\UserManagement;

use Spatie\Permission\Models\Role as UserRole; 
use Spatie\Permission\Models\Permission;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class Role extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'created_at';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $name , $title, $guard_name = 'web', $description;    
    public $listOfPermissions;
    
    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules() {
        return [
            'name' => ['required'],    
            'guard_name' => ['required'],
            'title' => ['nullable'],            
            'description' => ['nullable'],                    
        ];
    }

    public function resetInputs()
    {
       $this->guard_name = 'web';
       $this->description = '';
       $this->name = '';
       $this->title = '';       
       $this->selected_id = '';
       $this->deleteId = '';       
    }

    public function render()
    {        
        $this->listOfPermissions = Permission::orderBy('name')->get();
    	return view('livewire.user-management.role', [
            'roles' => UserRole::search($this->search)
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
                'name' => $this->name,
                'title' => $this->title,
            ];
            DB::beginTransaction();            
            $cr = UserRole::create($data);
            DB::commit();                      
            $this->resetInputs();
            $this->emit('roleCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('roleFailed', $e->getMessage());
            return $e->getMessage();
        }
    }
    
    public function addPermission($id) {
        
    }
    
    public function removePermission($id) {
        
    }

    public function edit($id)
    {   
        $grading = UserRole::where('id', $id)->first();
        $this->selected_id = $id;
        $this->guard_name = $grading->guard_name;    
        $this->description = $grading->description;       
        $this->name = $grading->name;      
        $this->title = $grading->title;      
    }

    public function update()
    {
        $this->validate();
        if($this->selected_id) {
            $act = UserRole::find($this->selected_id);
            try {
                DB::beginTransaction();
                $act->update([
                    'guard_name' => $this->guard_name,     
                    'description' => $this->description,    
                    'name' => $this->name,     
                    'title' => $this->title,                             
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('roleUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('roleFailed', $e->getMessage());
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
        $role = UserRole::where('id', $this->deleteId)->delete();
        $this->resetInputs();
        $this->emit('roleDeleted');        
    }
    
}
