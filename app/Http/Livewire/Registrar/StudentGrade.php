<?php

namespace App\Http\Livewire\Registrar;

use App\Models\StudentRecord;
use App\Models\SectionSubject;

use Livewire\Component;
use App\Models\Assessment;
use Livewire\WithPagination;
use DB;
use Exception;


class StudentGrade extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $student_id, $section_id;

    protected function rules() {
        return [
            'student_id' => ['required'],
            'section_id' => ['required'],
        ];
    }
    public function resetInputs()
    {
       $this->student_id = '';
       $this->section_id = '';
       $this->deleteId = '';   
       $this->selected_id = '';
    }
    public function mount($student_id, $section_id) {
        $this->student_id = $student_id;
        $this->section_id = $section_id;
    }
    public function render()
    {
        $student = StudentRecord::where('id', $this->student_id)->first();
    	return view('livewire.registrar.student-grade', [
    	    'student' => $student,
            'subjects' => SectionSubject::where('section_id', $this->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');        
    }
    
    public function activityGrades($studentID, $ssid)
    {
    	return redirect()->route('activity.grades', ['studentID' => $studentID, 'ssid' => $ssid]);
    }
}
