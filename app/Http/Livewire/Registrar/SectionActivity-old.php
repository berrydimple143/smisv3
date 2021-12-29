<?php

namespace App\Http\Livewire\Registrar;

use App\Models\SectionActivity as StudentActivity;
use App\Models\Section;
use App\Models\GradeCriteria;
use App\Models\ClassActivity;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class SectionActivity extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $section_id, $class_activity_id;
    public $listOfActivities;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules(){
        return [
            'section_id' => ['required'],
            'class_activity_id' => ['required'],            
        ];
    }

    public function resetInputs()
    {
       $this->class_activity_id = '';       
       $this->selected_id = '';   
       $this->deleteId = '';
    }

    public function mount($id) {
        $this->section_id = $id;
    }

    public function render()
    {

        $section = Section::where('id', $this->section_id)->first();
        $grdc = GradeCriteria::where('grading_system_id', $section->grading_system_id)->get();
        $cr_ids = [];
        foreach ($grdc as $gr) {
            $cr_ids[] = $gr->criteria_id;
        }
        $this->listOfActivities = ClassActivity::whereIn('criteria_id', $cr_ids)->get();        
    	return view('livewire.registrar.section-activity', [
            'sectionName' => $section->name,
            'activities' => StudentActivity::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');          
    }

    public function store() {
        $this->validate();
        $secID = $this->section_id;
        $clID = $this->class_activity_id;
        if(StudentActivity::where('section_id', $secID)->where('class_activity_id', $clID)->count() > 0) { 
            $this->resetInputs();
            $this->emit('alreadyExist');
        } else {
            try {
                $data = [
                    'section_id' => $secID,
                    'class_activity_id' => $clID,                
                ];
                DB::beginTransaction();            
                $tsk = StudentActivity::create($data);
                $clAct = ClassActivity::where('id', $clID)->update(['used' => 'yes']);
                DB::commit();                           
                $this->resetInputs();
                $this->emit('sectionActivityCreated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('sectionActivityFailed', $this->section_id);
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
        $sa = StudentActivity::where('id', $this->deleteId)->first();
        $clAct = ClassActivity::where('id', $sa->class_activity_id)->update(['used' => 'no']);
        $tsk = StudentActivity::where('id', $this->deleteId)->delete();
        $this->emit('sectionActivityDeleted');
    }
    
}
