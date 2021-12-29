<?php

namespace App\Http\Livewire\Faculty;

use App\Models\StudentRecord;
use App\Models\Section;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class Student extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'first_name';
    public $orderAsc = true;
    public $selected_id, $deleteId;
    public $first_name, $last_name, $email, $contact_number, $status;
    public $listOfSections;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    public function render()
    {      
      $this->listOfSections = Section::where('grading_system_id', '!=', null)->orderBy('created_at', 'desc')->get();
      return view('livewire.faculty.student', [
            'students' => StudentRecord::search($this->search)
            ->with('student', 'StudentStatus', 'course.classification', 'enrolment', 'creditedsubject')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
      ])->extends('layouts.app');
    }

    public function addSection($id) {
      $this->selected_id = $id;
    }

    public function storeSection() {
      $this->validate(['section_id' => ['required']]);
      try {
          $upd = StudentRecord::where('id', $this->selected_id)->update(['section_id' => $this->section_id]);
          $this->resetInputs();
          $this->emit('sectionAdded');
      } catch (Exception $e) {
          DB::rollBack();
          $this->emit('sectionAdditionFailed', $e->getMessage());
          return $e->getMessage();
      }
    }

    public function addGrade($id) {
      $this->selected_id = $id;
    }

    public function resetInputs()
    {       
       $this->email = '';
       $this->mobile = '';
       $this->status = '';
       $this->type = '';
       $this->account_id = '';
       $this->section_id = '';
       $this->first_name = '';
       $this->last_name = '';
       $this->selected_id = '';
       $this->deleteId = '';       
    }
}
