<?php

namespace App\Http\Livewire\Faculty;

use App\Models\Subject;
use App\Models\Section;
use App\Models\StudentRecord;
use App\Models\SubjectCriteria;
use App\Models\ClassRecord;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class ViewStudentGrade extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'activity_name';
    public $orderAsc = true;
    public $deleteId, $chosen_id;
    public $section_id, $subject_id, $teacher_id, $course_id, $school_year_id, $semester_id, $criteria_id, $student_id, $subject_criteria_id;
    public $activity_name, $item, $score;
    
    protected $listeners = ['resetInputs'];
    
    protected function rules() {
        return [
            'activity_name' => ['required'],
            'item' => ['required'],
            'score' => ['required'],
        ];
    }
    
    public function mount($section_id, $subject_id, $student_id, $teacher_id, $course_id, $school_year_id, $semester_id, $criteria_id, $subject_criteria_id) {
        $this->section_id = $section_id;
        $this->subject_id = $subject_id;
        $this->teacher_id = $teacher_id;
        $this->course_id = $course_id;
        $this->school_year_id = $school_year_id;
        $this->semester_id = $semester_id;
        $this->criteria_id = $criteria_id;
        $this->student_id = $student_id;
        $this->subject_criteria_id = $subject_criteria_id;
    }
    public function resetInputs()
    {
       $this->activity_name = '';
       $this->item = ''; 
       $this->score = ''; 
       $this->deleteId = '';
       $this->chosen_id = ''; 
    }
    public function render()
    {
        return view('livewire.faculty.view-student-grade', [
            'subject' => Subject::where('id', $this->subject_id)->first(),
            'section' => Section::where('id', $this->section_id)->first(),
            'student' => StudentRecord::where('id', $this->student_id)->first(),
            'activity' => SubjectCriteria::where('id', $this->subject_criteria_id)->first(),
            'activityGrades' => ClassRecord::where('course_id', $this->course_id)
                ->where('section_id', $this->section_id)
                ->where('subject_id', $this->subject_id)
                ->where('criteria_id', $this->criteria_id)
                ->where('teacher_id', $this->teacher_id)
                ->where('school_year_id', $this->school_year_id)
                ->where('semester_id', $this->semester_id)
                ->where('student_id', $this->student_id)
                ->where('subject_criteria_id', $this->subject_criteria_id)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
            ])->extends('layouts.app');
    }
    public function store() {
        $this->validate();
        try {
            $data = [
                'section_id' => $this->section_id,
                'subject_id' => $this->subject_id,
                'student_id' => $this->student_id,
                'teacher_id' => $this->teacher_id,
                'course_id' => $this->course_id,
                'school_year_id' => $this->school_year_id,
                'semester_id' => $this->semester_id,
                'criteria_id' => $this->criteria_id,
                'subject_criteria_id' => $this->subject_criteria_id,
                'activity_name' => $this->activity_name,
                'item' => $this->item,
                'score' => $this->score,
            ];
            DB::beginTransaction();            
            $tsk = ClassRecord::create($data);
            DB::commit();                           
            $this->resetInputs();
            $this->emit('studentViewGradeAdded', $data);
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('studentGradeFailed', $e->getMessage());
            return $e->getMessage();
        }
    }
    public function edit($id) {
        $this->chosen_id = $id; 
        $record = ClassRecord::where('id', $id)->first();
        $this->item = $record->item;
        $this->score = $record->score;
        $this->activity_name = $record->activity_name;   
    }
    public function update()
    {
        $this->validate();
        if($this->chosen_id) {
            $record = ClassRecord::find($this->chosen_id);
            try {
                DB::beginTransaction();
                $data = [
                    'section_id' => $record->section_id,
                    'subject_id' => $record->subject_id,
                    'student_id' => $record->student_id,
                    'teacher_id' => $record->teacher_id,
                    'course_id' => $record->course_id,
                    'school_year_id' => $record->school_year_id,
                    'semester_id' => $record->semester_id,
                    'criteria_id' => $record->criteria_id,
                    'subject_criteria_id' => $record->subject_criteria_id,
                    'item' => $this->item,
                    'score' => $this->score,   
                    'activity_name' => $this->activity_name, 
                ];
                $record->update($data);         
                DB::commit();
                $this->resetInputs();
                $this->emit('studentViewGradeUpdated', $data);
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('studentGradeFailed', $e->getMessage());
                return $e->getMessage();
            }
        }
    }
    public function deleteThisId($id) {
        $this->deleteId = $id;
    }
    public function deleteNow() {
        $gr = ClassRecord::where('id', $this->deleteId)->first();
        $data = [
            'section_id' => $gr->section_id,
            'subject_id' => $gr->subject_id,
            'student_id' => $gr->student_id,
            'teacher_id' => $gr->teacher_id,
            'course_id' => $gr->course_id,
            'school_year_id' => $gr->school_year_id,
            'semester_id' => $gr->semester_id,
            'criteria_id' => $gr->criteria_id,
            'subject_criteria_id' => $gr->subject_criteria_id,
        ];
        $grade = ClassRecord::where('id', $this->deleteId)->delete();
        $this->resetInputs();
        $this->emit('studentViewGradeDeleted', $data);
    }
}
