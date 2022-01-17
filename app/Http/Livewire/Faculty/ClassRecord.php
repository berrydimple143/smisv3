<?php

namespace App\Http\Livewire\Faculty;

use App\Models\ClassRecord as SchoolClassRecord;
use App\Models\Subject;
use App\Models\Section;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Classification;
use App\Models\Course;
use App\Models\User;
use App\Models\Criteria;
use App\Models\Classes;
use App\Models\StudentRecord;
use App\Http\Controllers\HelperController;

use Livewire\Component;
use App\Models\Assessment;
use Livewire\WithPagination;
use DB;
use Exception;
use Illuminate\Http\Request;

class ClassRecord extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'last_name';
    public $orderAsc = true;
    public $deleteId;
    public $section_id = '', $quarter_id, $subject_id, $teacher_id, $course_id = '', $school_year_id, $semester_id;
    public $listOfSubjects, $listOfSections, $listOfTeachers, $listOfSchoolYear, $listOfGradeLevel, $listOfSemester, $listOfCriteria;
    public $showButton = false;
    
    protected $listeners = ['resetInputs'];
    
    protected function rules() {
        return [
            'section_id' => ['required'],
            'subject_id' => ['required'],
            'teacher_id' => ['required'],
            'course_id' => ['required'],
            'school_year_id' => ['required'],
            'semester_id' => ['required'],
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
    }
    
    public function mount(Request $request) {
        $this->section_id = $request->section_id;
        $this->subject_id = $request->subject_id;
        $this->teacher_id = $request->teacher_id;
        $this->course_id = $request->course_id;
        $this->school_year_id = $request->school_year_id;
        $this->semester_id = $request->semester_id;
        if((empty($this->course_id)) and (empty($this->section_id))) {
            $this->course_id = '';
            $this->section_id = '';
        }
    }
    
    public function render()
    {
        $scyear = SchoolYear::where('status', 1)->first();
        $this->school_year_id = $scyear->id;
        $classification = Classification::where('description', 'Basic Education')->first();
        $courseIds = [];
        $this->listOfGradeLevel = Course::where('classification_id', $classification->id)->orderBy('name')->get();
        foreach($this->listOfGradeLevel as $level) {
            $courseIds[] = $level->id;
        }
        $this->listOfCriteria = Criteria::where('active', 'yes')->orderBy('id', 'desc')->get();
        $this->listOfSections = Section::whereIn('course_id', $courseIds)->orderBy('name')->get();
        $this->listOfSchoolYear = SchoolYear::orderBy('created_at', 'desc')->get();
        $this->listOfSemester = Semester::where('school_year_id', $this->school_year_id)->orderBy('created_at', 'desc')->get();
        $this->listOfTeachers = User::role('teacher')->get();
        if(!empty($this->school_year_id)) {
            $this->semester_id = '';
            $sem = Semester::where('school_year_id', $this->school_year_id)->where('status', 'active')->first();
            if($sem) {
                $this->semester_id = $sem->id;
            } 
        }
        if((!empty($this->course_id)) and (!empty($this->section_id))) {
            $cls = Classes::where('course_id', $this->course_id)->where('section_id', $this->section_id)->first();
            if($cls) {
                $this->teacher_id = $cls->teacher_id;
                $subjectIds = [];
                $subjects = Classes::where('course_id', $this->course_id)->where('section_id', $this->section_id)->where('teacher_id', $this->teacher_id)->get();     
                foreach($subjects as $subj) {
                    $subjectIds[] = $subj->subject_id;
                }                
                $sbjs = Subject::whereIn('id', $subjectIds)->orderBy('description')->get();
                $this->listOfSubjects = $sbjs;
                if($sbjs->count() == 1) {
                    $this->subject_id = $subjectIds[0];
                } 
            }            
        } 
        if((!empty($this->course_id)) and (!empty($this->section_id)) and (!empty($this->teacher_id)) and (!empty($this->subject_id))) {
            $this->showButton = true;
        }
    	return view('livewire.faculty.class-record', [
            'students' => StudentRecord::where('course_id', $this->course_id)->where('section_id', $this->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }
}
