<?php

namespace App\Http\Livewire\Grading;

use App\Models\GradeCriteria as StudentGradeCriteria;
use App\Models\GradingSystem;
use App\Models\Criteria;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class GradeCriteria extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public $selected_id, $deleteId;
    public $criteria_id, $grading_system_id, $percent;
    public $listOfCriteria;

    protected $listeners = ['resetAllInputs' => 'resetInputs', 'checkPercentLimit', 'checkCriteriaLimit'];

    protected function rules() {
        return [
            'criteria_id' => ['required'],    
            'grading_system_id' => ['required'],
            'percent' => ['required'],               
        ];
    }

    public function mount($id) {
    	$this->grading_system_id = $id;
    }

    public function checkCriteriaLimit($grcId) {       
        $indicator = $this->limitExceeded($grcId);        
        if($indicator == "ok") {
            $this->emit('limitAvailable', $this->percentRemaining($grcId));
        }
    }

    public function percentRemaining($grId) {
        $grcriteria = StudentGradeCriteria::where('grading_system_id', $grId)->get();
        $cntr = 0;
        foreach ($grcriteria as $grcr) {
            $cntr += (int)$grcr->percent;            
        }
        $diff = 100 - $cntr;
        return $diff;
    }

    public function checkPercentLimit() {        
        $indicator = $this->getLimit();
        if($indicator == "not") {
            $this->emit('criteriaLimitExceeded');
        }
    }

    public function getLimit() {
        $limit = "ok";
        $sgc = StudentGradeCriteria::where('id', $this->selected_id)->first();
        $grcriteria = StudentGradeCriteria::where('grading_system_id', $this->grading_system_id)->get();
        $cntr = 0;
        foreach ($grcriteria as $grcr) {
            if($grcr->id != $sgc->id) {
                $cntr += (int)$grcr->percent;
            }
        }
        $cntr += $this->percent;
        if($cntr > 100) {                        
            $limit = "not";
        }
        return $limit;
    }

    public function render()
    {    	
    	$crt = GradingSystem::where('id', $this->grading_system_id)->first();
        $this->listOfCriteria = Criteria::all();
    	return view('livewire.grading.grade-criteria', [
    		'gradingType' =>  $crt->type,
            'gradecriteria' => StudentGradeCriteria::where('grading_system_id', $this->grading_system_id)            
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');        
    }

    public function limitExceeded($grsId) {
        $indicator = "ok";
        if(StudentGradeCriteria::where('grading_system_id', $grsId)->count() > 0) {
            $grc = StudentGradeCriteria::where('grading_system_id', $grsId)->get();
            $cntr = 0;
            foreach ($grc as $gr) {
                $cntr += (int)$gr->percent;
            }   
            if($cntr >= 100) {
                $indicator = "not";
            }
        }
        return $indicator;
    }

    public function store() {                   
        $this->validate();       
        $indicator = $this->limitExceeded($this->grading_system_id);        
        if($indicator == "ok") {
            try {      
                $data = [
                    'criteria_id' => $this->criteria_id,
                    'grading_system_id' => $this->grading_system_id,
                    'percent' => $this->percent,
                ];
                DB::beginTransaction();            
                $cr = StudentGradeCriteria::create($data);
                $updcr = Criteria::where('id', $this->criteria_id)->update(['status' => 'used']);
                DB::commit();                      
                $this->resetInputs();
                $this->emit('gradeCriteriaCreated', $this->grading_system_id);
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('gradeCriteriaFailed', $this->grading_system_id);
                return $e->getMessage();
            }
        } else {
            $this->resetInputs();
            $this->emit('gradeCriteriaLimit');
        }        
    }

    public function edit($id)
    {   
        $criteria = StudentGradeCriteria::where('id', $id)->first();
        $this->selected_id = $id;
        $this->criteria_id = $criteria->criteria_id;   
        $this->percent = $criteria->percent;     
        $this->grading_system_id = $criteria->grading_system_id;   
    }

    public function update()
    {
        $this->validate();        
        if($this->selected_id) {
            $indicator = $this->getLimit();
            if($indicator == "not") {
                $this->emit('criteriaLimitExceeded');
            } else {
                $act = StudentGradeCriteria::find($this->selected_id);
                try {
                    DB::beginTransaction();
                    $act->update([
                        'criteria_id' => $this->criteria_id,           
                        'percent' => $this->percent,       
                        'grading_system_id' => $this->grading_system_id,                                 
                    ]);         
                    DB::commit();
                    $this->resetInputs();
                    $this->emit('criteriaUpdated');
                } catch (Exception $e) {
                    DB::rollBack();
                    $this->emit('criteriaFailed', $e->getMessage());
                    return $e->getMessage();
                }
            }
        }
    }

    public function deleteThisId($id)
    {
        $this->deleteId = $id;
    }
    
    public function deleteNow()
    {
        $cr = StudentGradeCriteria::where('id', $this->deleteId)->delete();
        $this->resetInputs();
        $this->emit('gradeCriteriaDeleted');        
    }

    public function resetInputs()
    {
       $this->criteria_id = '';
       $this->percent = '';
       $this->selected_id = '';
       $this->deleteId = '';       
    }
}
