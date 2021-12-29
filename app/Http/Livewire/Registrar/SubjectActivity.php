<?php

namespace App\Http\Livewire\Registrar;

use App\Models\SubjectActivity as StudentSubjectActivity;
use App\Models\Subject;
use App\Models\Section;
use App\Models\ClassActivity;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class SubjectActivity extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $section_id, $class_activity_id, $subject_id;
    public $listOfActivities;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules(){
        return [
            'class_activity_id' => ['required'],            
        ];
    }

    public function resetInputs()
    {
       $this->class_activity_id = '';     
       $this->selected_id = '';   
       $this->deleteId = '';
    }

    public function mount($subjectId, $sectionId) {
        $this->subject_id = $subjectId;
        $this->section_id = $sectionId;
    }

    public function render()
    {  
        $this->listOfActivities = ClassActivity::orderBy('name')->get();        
    	return view('livewire.registrar.subject-activity', [
            'subject' => Subject::where('id', $this->subject_id)->first(),
            'section' => Section::where('id', $this->section_id)->first(),
            'activities' => StudentSubjectActivity::where('subject_id', $this->subject_id)->where('section_id', $this->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');          
    }

    public function store() {
        $this->validate();
        $secID = $this->section_id;
        $subID = $this->subject_id;
        $clID = $this->class_activity_id;
        if(StudentSubjectActivity::where('section_id', $secID)->where('subject_id', $subID)->where('class_activity_id', $clID)->count() > 0) {
            $this->resetInputs();
            $this->emit('subjectActivityExist');
        } else {
            try {
                $data = [
                    'section_id' => $secID,
                    'class_activity_id' => $clID,   
                    'subject_id' => $subID,
                ];
                DB::beginTransaction();            
                $tsk = StudentSubjectActivity::create($data);
                $clAct = ClassActivity::where('id', $clID)->update(['used' => 'yes']);
                DB::commit();                           
                $this->resetInputs();
                $this->emit('subjectActivityCreated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('subjectActivityFailed', $e->getMessage());
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
        $sa = StudentSubjectActivity::where('id', $this->deleteId)->first();
        $clAct = ClassActivity::where('id', $sa->class_activity_id)->update(['used' => 'no']);
        $tsk = StudentSubjectActivity::where('id', $this->deleteId)->delete();
        $this->emit('subjectActivityDeleted');
    }
}
