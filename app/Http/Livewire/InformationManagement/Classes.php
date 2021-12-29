<?php

namespace App\Http\Livewire\InformationManagement;

use App\Models\Classes as SchoolClasses;
use App\Models\Subject;
use App\Models\Section;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Course;
use App\Models\User;

use Livewire\Component;
use App\Models\Assessment;
use Livewire\WithPagination;
use DB;
use Exception;

class Classes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $section_id, $subject_id, $teacher_id, $course_id, $school_year_id, $semester_id = '', $semester_description = '';
    public $listOfSubjects, $listOfSections, $listOfTeachers, $listOfSchoolYear, $listOfGradeLevel;
    
    protected function rules() {
        return [
            'section_id' => ['required'],
            'subject_id' => ['required'],
            'teacher_id' => ['required'],
            'course_id' => ['required'],
            'school_year_id' => ['required'],
            'semester_id' => ['nullable'],
        ];
    }
    public function resetInputs()
    {
       $this->section_id = '';
       $this->subject_id = '';
       $this->teacher_id = '';
       $this->course_id = '';
       $this->school_year_id = '';
       $this->semester_id = '';
       $this->deleteId = '';   
       $this->selected_id = '';
    }
    public function render()
    {
        $this->listOfSubjects = Subject::orderBy('description')->get();
        $this->listOfSections = Section::orderBy('name')->get();
        $this->listOfSchoolYear = SchoolYear::orderBy('created_at', 'desc')->get();
        $this->listOfGradeLevel = Course::orderBy('name')->get();
        $this->listOfTeachers = User::role('teacher')->get();
        if(!empty($this->school_year_id)) {
            $this->semester_description = '';
            $this->semester_id = '';
            $sem = Semester::where('school_year_id', $this->school_year_id)->where('status', 'active')->first();
            if($sem) {
                $this->semester_description = $sem->description;
                $this->semester_id = $sem->id;
            } 
        }
    	return view('livewire.information-management.classes', [
            'classes' => SchoolClasses::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }
}
