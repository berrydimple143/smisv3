<?php

namespace App\Http\Livewire\Registrar;

use App\Models\SubjectActivity;
use App\Models\Subject;
use App\Models\Section;
use App\Models\SectionSubject;
use App\Models\StudentRecord;
use App\Models\ActivityGrade;
use App\Models\ClassActivity;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;
use ICanBoogie\Inflector;

class SubjectGrade extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $view_id, $activity_number, $activity_name = '';
    public $student_id, $section_subject_id, $subject_id, $section_id, $item, $score;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];
    
    protected function rules() {
        return [
            'item' => ['required'],
            'score' => ['required'],
            'activity_number' => ['required'],
            'activity_name' => ['nullable'],
        ];
    }
    
    public function resetInputs()
    {
       $this->item = '';     
       $this->score = '';     
       $this->activity_name = '';  
       $this->activity_number = ''; 
       $this->selected_id = '';   
       $this->view_id = '';
    }

    public function mount($studentID, $ssid) {
        $this->student_id = $studentID;
        $this->section_subject_id = $ssid;
    }

    public function render()
    {
        $secsub = SectionSubject::where('id', $this->section_subject_id)->first();
        $this->subject_id = $secsub->subject_id;
        $this->section_id = $secsub->section_id;
    	return view('livewire.registrar.subject-grade', [
    	    'student' => StudentRecord::where('id', $this->student_id)->first(),
            'subject' => Subject::where('id', $secsub->subject_id)->first(),
            'section' => Section::where('id', $secsub->section_id)->first(),
            'activities' => SubjectActivity::where('subject_id', $secsub->subject_id)->where('section_id', $secsub->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');          
    }
    
    public function addGrade($id, $aid) {
        $inflector = Inflector::get();
        $this->selected_id = $id; 
        $act = ClassActivity::where('id', $aid)->first();
        $this->activity_name = $inflector->singularize($act->name);
    }
    
    public function viewGrades($studentId, $sectionId, $subjectId, $activityId) {
        return redirect()->route('view.grades', ['studentId' => $studentId, 'sectionId' => $sectionId, 'subjectId' => $subjectId, 'activityId' => $activityId]);
    }

    public function store() {
        $this->validate();
        try {
            $data = [
                'section_id' => $this->section_id,
                'subject_id' => $this->subject_id,
                'student_id' => $this->student_id,
                'activity_id' => $this->selected_id,
                'activity_number' => $this->activity_number,
                'item' => $this->item,
                'score' => $this->score,
            ];
            DB::beginTransaction();            
            $tsk = ActivityGrade::create($data);
            DB::commit();                           
            $this->resetInputs();
            $this->emit('activityGradeAdded');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('activityGradeFailed', $e->getMessage());
            return $e->getMessage();
        }
    }
}
