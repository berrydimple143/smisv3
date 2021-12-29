<?php

namespace App\Http\Livewire\Grading;

use App\Models\GradingSystem as StudentGradingSystem;
use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use App\Models\Subject;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class GradingSystem extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;
    public $selected_id, $deleteId;
    public $user_id, $course_id, $section_id, $subject_id, $selected;
    public $listOfTeachers, $listOfCourses, $listOfSections, $listOfSubjects;
    
    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules() {
        return [
            'user_id' => ['required'],    
            'course_id' => ['required'],
            'section_id' => ['required'],
            'subject_id' => ['required'],
            'selected' => ['nullable'],               
        ];
    }

    public function resetInputs()
    {
       $this->user_id = '';
       $this->selected = '';
       $this->course_id = '';
       $this->section_id = '';
       $this->subject_id = '';
       $this->selected_id = '';
       $this->deleteId = '';       
    }

    public function render()
    {
        $this->listOfTeachers = User::where('type', 'faculty')->orderBy('last_name')->get();
        $this->listOfCourses = Course::orderBy('id')->get();
        $this->listOfSections = Section::orderBy('name')->get();
        $this->listOfSubjects = Subject::orderBy('description')->get();
    	return view('livewire.grading.grading-system', [
            'gradings' => StudentGradingSystem::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');        
    }

    public function store() {             
        $this->validate();        
        try {      
            $data = [
                'user_id' => $this->user_id,
                'course_id' => $this->course_id,
                'section_id' => $this->section_id,
                'subject_id' => $this->subject_id,
            ];
            DB::beginTransaction();            
            $cr = StudentGradingSystem::create($data);
            DB::commit();                      
            $this->resetInputs();
            $this->emit('systemCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('systemFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit($id)
    {   
        $grading = StudentGradingSystem::where('id', $id)->first();
        $this->selected_id = $id;
        $this->user_id = $grading->user_id;    
        $this->course_id = $grading->course_id;       
        $this->section_id = $grading->section_id;      
        $this->subject_id = $grading->subject_id;      
    }

    public function update()
    {
        $this->validate();
        if($this->selected_id) {
            $act = StudentGradingSystem::find($this->selected_id);
            try {
                DB::beginTransaction();
                $act->update([
                    'user_id' => $this->user_id,     
                    'course_id' => $this->course_id,    
                    'section_id' => $this->section_id,     
                    'subject_id' => $this->subject_id,                             
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('systemUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('systemFailed', $e->getMessage());
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
        $id = $this->deleteId;
        $act = StudentGradingSystem::where('id', $id)->first();
        if($act->selected == "yes") {
            $this->resetInputs();
            $this->emit('usedSystem');
        } else {
            $tsk = StudentGradingSystem::where('id', $id)->delete();
            $this->resetInputs();
            $this->emit('systemDeleted');
        }
    }

    public function view($id) {
        return redirect()->route('grade.criteria', ['id' => $id]);
    }    

}
