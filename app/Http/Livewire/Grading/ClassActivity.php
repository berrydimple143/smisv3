<?php

namespace App\Http\Livewire\Grading;

use App\Models\ClassActivity as StudentActivity;
use App\Models\Criteria;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class ClassActivity extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $name, $criteria_id;
    public $listOfCriteria;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules() {
        return [
            'name' => ['required'],
            'criteria_id' => ['required'],                              
        ];
    }

    public function resetInputs()
    {
       $this->name = '';
       $this->criteria_id = '';       
       $this->selected_id = '';   
       $this->deleteId = '';
       $this->listOfCriteria = '';
    }    

    public function render()
    {    	        
        $this->listOfCriteria = Criteria::all();
    	return view('livewire.grading.class-activity', [
            'activities' => StudentActivity::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }

    public function store() {                     
        $this->validate();        
        try {
            $data = [
                'name' => $this->name,
                'criteria_id' => $this->criteria_id,                
            ];
            DB::beginTransaction();            
            $tsk = StudentActivity::create($data);
            DB::commit();                           
            $this->resetInputs();
            $this->emit('activityCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('activityFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit($id)
    {   
        $activity = StudentActivity::where('id',$id)->first();
        $this->selected_id = $id;
        $this->name = $activity->name;
        $this->criteria_id = $activity->criteria_id;        
    }

    public function update()
    {
        $this->validate();
        if($this->selected_id) {
            $act = StudentActivity::find($this->selected_id);
            try {
                DB::beginTransaction();
                $act->update([
                    'name' => $this->name,
                    'criteria_id' => $this->criteria_id,                    
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('activityUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('activityFailed', $e->getMessage());
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
        $act = StudentActivity::where('id', $id)->first();
        if($act->used == "yes") {
            $this->resetInputs();
            $this->emit('usedActivity');
        } else {
            $tsk = StudentActivity::where('id', $id)->delete();
            $this->resetInputs();
            $this->emit('activityDeleted');
        }
    }

}
