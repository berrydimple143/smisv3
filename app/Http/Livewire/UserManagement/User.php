<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User as UserList;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class User extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'created_at';
    public $orderAsc = false;
    public $selected_id, $deleteId, $chosen_id, $remove_id;
    public $first_name, $last_name, $email, $mobile, $role, $role2, $type = 'faculty';  
    public $listOfRoles, $listOfRolesToRemove;  
    
    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules() {
        return [
            'first_name' => ['required'],    
            'last_name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['nullable'],
            'type' => ['nullable'],                    
        ];
    }

    public function resetInputs()
    {
       $this->first_name = '';
       $this->last_name = '';
       $this->email = '';
       $this->mobile = '';
       $this->type = 'faculty';       
       $this->role = '';  
       $this->selected_id = '';
       $this->deleteId = '';   
       $this->chosen_id = '';     
       $this->remove_id = '';      
    }

    public function render()
    {        
    	$this->listOfRoles = Role::orderBy('name')->get();
    	return view('livewire.user-management.user', [
            'users' => UserList::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');        
    }

    public function store() {         
        $this->validate();        
        try {      
            $data = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'type' => $this->type,
                'password' => Hash::make('12345'),
            ];
            DB::beginTransaction(); 
            $cr = UserList::create($data);
            DB::commit();                      
            $this->resetInputs();
            $this->emit('userCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('userFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function storeRole() {     
        $this->validate([
        	'role' => ['required'],
        ]);        
        try {      
            DB::beginTransaction(); 
            	$user = UserList::where('id', $this->chosen_id)->first();
            	$role = Role::where('name','teacher')->first();
                $role->givePermissionTo('faculty-load');
                $user->assignRole($role);
                $user->givePermissionTo('faculty-load');
            DB::commit();                      
            $this->resetInputs();
            $this->emit('userRoleCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('addRoleFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function addRole($id) {
    	$this->chosen_id = $id;
    }

    public function removeRole($id) {
        $this->remove_id = $id;
        $user = UserList::where('id', $id)->first();
        $this->listOfRolesToRemove = $user->getRoleNames();
    }
    
    public function removeRoleNow() {
        $this->validate(['role2' => ['required']]);
        try {
            DB::beginTransaction();
                $user = UserList::where('id', $this->remove_id)->first();
                $user->removeRole($this->role2);
            DB::commit();
            $this->resetInputs();
            $this->emit('userRoleRemoved');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('userFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit($id)
    {   
        $user = UserList::where('id', $id)->first();
        $this->selected_id = $id;
        $this->first_name = $user->first_name;    
        $this->last_name = $user->last_name;  
        $this->email = $user->email;       
        $this->mobile = $user->mobile;      
        $this->type = $user->type;      
    }

    public function update()
    {
        $this->validate([
        	'first_name' => ['required'],    
            'last_name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile' => ['nullable'],
            'type' => ['nullable'],
        ]);
        if($this->selected_id) {
            $act = UserList::find($this->selected_id);
            try {
                DB::beginTransaction();
                $act->update([
                    'first_name' => $this->first_name,     
                    'last_name' => $this->last_name,    
                    'email' => $this->email,
                    'mobile' => $this->mobile,     
                    'type' => $this->type,                             
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('userUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('userFailed', $e->getMessage());
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
        $role = UserList::where('id', $this->deleteId)->delete();
        $this->resetInputs();
        $this->emit('userDeleted');        
    }
   
}
