<?php

namespace App\Http\Livewire\Faculty;

use App\Models\User;
use App\Models\Section;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class Teacher extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'first_name';
    public $orderAsc = true;
    public $selected_id, $deleteId;
    public $name, $first_name, $last_name, $email, $mobile, $status, $type, $account_id;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    public function render()
    {
        $arr = [];
        $sections = Section::all();
        foreach ($sections as $section) {
            $arr[] = $section->user_id;
        }
    	return view('livewire.faculty.teacher', [
            'teachers' => User::whereIn('id', $arr)->where('type', 'faculty')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }

    public function resetInputs()
    {
       $this->name = '';
       $this->email = '';
       $this->mobile = '';
       $this->status = '';
       $this->type = '';
       $this->account_id = '';
       $this->first_name = '';
       $this->last_name = '';
       $this->selected_id = '';
       $this->deleteId = '';       
    }    
}
