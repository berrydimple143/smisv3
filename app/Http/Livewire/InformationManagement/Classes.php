<?php

namespace App\Http\Livewire\InformationManagement;

use App\Models\Classes as SchoolClasses;
use App\Models\Subject;
use App\Models\Section;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Classification;
use App\Models\Course;
use App\Models\User;
use App\Models\Assessment;

use Livewire\Component;
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
    public $deleteId;
    public $section_id, $subject_id, $teacher_id, $course_id, $school_year_id, $semester_id;
    public $listOfSubjects, $listOfSections, $listOfTeachers, $listOfSchoolYear, $listOfGradeLevel, $listOfSemester;
    
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
    public function render()
    {
        $scyear = SchoolYear::where('status', 1)->first();
        $this->school_year_id = $scyear->id;
        $classification = Classification::where('description', 'Basic Education')->first();
        $this->listOfSubjects = Subject::where('classification_id', $classification->id)->orderBy('description')->get();
        $courseIds = [];
        $this->listOfGradeLevel = Course::where('classification_id', $classification->id)->orderBy('name')->get();
        foreach($this->listOfGradeLevel as $level) {
            $courseIds[] = $level->id;
        }
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
    	return view('livewire.information-management.classes', [
            'classes' => SchoolClasses::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }
    public function store() {
        $this->validate();
        if(SchoolClasses::where('section_id', $this->section_id)
            ->where('subject_id', $this->subject_id)
            ->where('teacher_id', $this->teacher_id)
            ->where('course_id', $this->course_id)
            ->where('school_year_id', $this->school_year_id)
            ->where('semester_id', $this->semester_id)
            ->count() <= 0) {
            try {
                $data = [
                    'section_id' => $this->section_id,
                    'subject_id' => $this->subject_id,
                    'teacher_id' => $this->teacher_id,
                    'course_id' => $this->course_id,
                    'school_year_id' => $this->school_year_id,
                    'semester_id' => $this->semester_id,
                ];
                DB::beginTransaction();            
                $sy = SchoolClasses::create($data);
                DB::commit();
                $this->resetInputs();
                $this->emit('classCreated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('classFailed', $e->getMessage());
                return $e->getMessage();
            }
        } else {
            $this->resetInputs();
            $this->emit('classExist');
        }
    }
    public function deleteThisId($id) {
        $this->deleteId = $id;
    }
    public function deleteNow() {
        $sc = SchoolClasses::where('id', $this->deleteId)->delete();
        $this->resetInputs();
        $this->emit('classDeleted');
    }
}
