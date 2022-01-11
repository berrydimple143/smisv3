<?php

namespace App\Http\Livewire\Faculty;

use App\Models\SubjectCriteria as StudentSubjectCriteria;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Classification;
use App\Models\Criteria;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use DB;
use Exception;

class SubjectCriteria extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $description, $criteria_id, $subject_id, $course_id;
    public $listOfGradeLevel, $listOfSubjects, $listOfCriteria;
    public $addBtnClass = "disabled", $addBtnStyle = "default";

    protected $listeners = ['resetInputs'];

    protected function rules() {
        return [
            'description' => ['required'],
            'criteria_id' => ['required'],       
            'subject_id' => ['required'],
            'course_id' => ['required'],    
        ];
    }
    
    public function mount(Request $request) {
        if($request->input('cid')) {
            $this->course_id = $request->input('cid');
        }
        if($request->input('sid')) {
            $this->subject_id = $request->input('sid');
        }
    }

    public function resetInputs()
    {
       $this->description = '';
       $this->criteria_id = ''; 
       $this->selected_id = '';   
       $this->deleteId = '';
    }    

    public function render()
    {    	        
        $course = $subject = "";
        if((!empty($this->course_id)) and (!empty($this->subject_id))) {
            $this->addBtnClass = "";
            $this->addBtnStyle = "success";
            $course = Course::where('id', $this->course_id)->first();
            $subject = Subject::where('id', $this->subject_id)->first();
        }
        $this->listOfCriteria = Criteria::all();
        $classification = Classification::where('description', 'Basic Education')->first();
        $this->listOfSubjects = Subject::where('classification_id', $classification->id)->orderBy('description')->get();
        $this->listOfGradeLevel = Course::where('classification_id', $classification->id)->orderBy('name')->get();
    	return view('livewire.faculty.subject-criteria', [
    	    'course' => $course,
    	    'subject' => $subject,
    	    'criteria' => StudentSubjectCriteria::where('course_id', $this->course_id)->where('subject_id', $this->subject_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }

    public function store() {           
        $this->validate();    
        $csid = $this->course_id . '|@|' . $this->subject_id;
        if(StudentSubjectCriteria::where('course_id', $this->course_id)
            ->where('subject_id', $this->subject_id)
            ->where('criteria_id', $this->criteria_id)
            ->where('description', $this->description)->count() <= 0) {
            try {
                $data = [
                    'description' => $this->description,
                    'criteria_id' => $this->criteria_id,  
                    'subject_id' => $this->subject_id,
                    'course_id' => $this->course_id,
                ];
                DB::beginTransaction();            
                $tsk = StudentSubjectCriteria::create($data);
                DB::commit();                           
                $this->resetInputs();
                $this->emit('subjectCriteriaCreated', $csid);
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('subjectCriteriaFailed', $e->getMessage());
                return $e->getMessage();
            }
        } else {
            $this->resetInputs();
            $this->emit('subjectCriteriaExist', $csid);
        }
    }

    public function edit($id)
    {   
        $activity = StudentSubjectCriteria::where('id',$id)->first();
        $this->selected_id = $id;
        $this->description = $activity->description;
        $this->criteria_id = $activity->criteria_id;   
        $this->course_id = $activity->course_id;
        $this->subject_id = $activity->subject_id;
    }

    public function update()
    {
        $this->validate([
            'description' => ['required'],
            'criteria_id' => ['required'],
        ]);
        $csid = $this->course_id . '|@|' . $this->subject_id;
        if($this->selected_id) {
            $act = StudentSubjectCriteria::find($this->selected_id);
            try {
                DB::beginTransaction();
                $act->update([
                    'description' => $this->description,
                    'criteria_id' => $this->criteria_id,                    
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('subjectCriteriaUpdated', $csid);
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('subjectCriteriaFailed', $e->getMessage());
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
        $tsk = StudentSubjectCriteria::where('id', $this->deleteId)->delete();
        $this->resetInputs();
        $this->emit('subjectCriteriaDeleted');
    }
}
