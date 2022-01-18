<?php

namespace App\Http\Livewire\Faculty;

use App\Models\SubjectCriteria;
use App\Models\ClassRecord;

use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use DB;
use Exception;

class WrittenWork extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'description';
    public $orderAsc = true;
    public $deleteId, $chosen_id;
    public $section_id = '', $quarter_id, $subject_id, $teacher_id, $course_id = '', $school_year_id, $semester_id, $criteria_id, $student_id;
    public $listOfSubjects, $listOfSections, $listOfTeachers, $listOfSchoolYear, $listOfGradeLevel, $listOfSemester, $listOfCriteria;
    public $item, $score, $subject_criteria_id, $activity_name = '';
    public $showButton = false;
    
    protected $listeners = ['resetInputs', 'addGrade'];
    
    protected function rules() {
        return [
            'activity_name' => ['required'],
            'item' => ['required'],
            'score' => ['required'],
        ];
    }
    public function resetInputs()
    {
       $this->deleteId = '';
       $this->item = ''; 
       $this->score = ''; 
       $this->activity_name = ''; 
       $this->chosen_id = ''; 
    }
    public function mount(Request $request) {
        $this->section_id = $request->section_id;
        $this->subject_id = $request->subject_id;
        $this->teacher_id = $request->teacher_id;
        $this->course_id = $request->course_id;
        $this->school_year_id = $request->school_year_id;
        $this->semester_id = $request->semester_id;
        $this->criteria_id = $request->criteria_id;
        $this->student_id = $request->student_id;
    }
    public function render()
    {
        return view('livewire.faculty.written-work', [
            'writtenWorks' => SubjectCriteria::where('course_id', $this->course_id)->where('subject_id', $this->subject_id)->where('criteria_id', $this->criteria_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }
    public function addGrade($id) {
        $this->chosen_id = $id;
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
                'subject_criteria_id' => $this->chosen_id,
                'activity_name' => $this->activity_name,
                'item' => $this->item,
                'score' => $this->score,
            ];
            DB::beginTransaction();            
            $tsk = ClassRecord::create($data);
            DB::commit();                           
            $this->resetInputs();
            $this->emit('studentGradeAdded', $data);
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('studentGradeFailed', $e->getMessage());
            return $e->getMessage();
        }
    }
    public function view($id) {
        $data = [
            'section_id' => $this->section_id,
            'subject_id' => $this->subject_id,
            'student_id' => $this->student_id,
            'teacher_id' => $this->teacher_id,
            'course_id' => $this->course_id,
            'school_year_id' => $this->school_year_id,
            'semester_id' => $this->semester_id,
            'criteria_id' => $this->criteria_id,
            'subject_criteria_id' => $id
        ];
        return redirect()->route('view.student.grades', $data);
    }
}
