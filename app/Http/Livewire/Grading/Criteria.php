<?php

namespace App\Http\Livewire\Grading;

use App\Models\Criteria as GradeCriteria;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class Criteria extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'description';
    public $orderAsc = true;
    public $selected_id, $deleteId;
    public $description;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules() {
        return [
            'description' => ['required'],                
        ];
    }

    public function render()
    {
    	return view('livewire.grading.criteria', [
            'criteria' => GradeCriteria::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }

    public function store() {                   
        $this->validate();
        if(GradeCriteria::where('description', $this->description)->count() > 0) {
            $this->resetInputs();
            $this->emit('criteriaExist');
        } else {
            try {
                DB::beginTransaction();            
                $cr = GradeCriteria::create(['description' => $this->description]);
                DB::commit();                      
                $this->resetInputs();
                $this->emit('criteriaCreated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('criteriaFailed', $e->getMessage());
                return $e->getMessage();
            }
        }
    }

    public function edit($id)
    {   
        $criteria = GradeCriteria::where('id', $id)->first();
        $this->selected_id = $id;
        $this->description = $criteria->description;        
    }

    public function update()
    {
        $this->validate();
        if($this->selected_id) {
            $act = GradeCriteria::find($this->selected_id);
            try {
                DB::beginTransaction();
                $act->update([
                    'description' => $this->description,                                     
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

    public function deleteThisId($id)
    {
        $this->deleteId = $id;
    }
    
    public function deleteNow()
    {
        $id = $this->deleteId;
        $act = GradeCriteria::where('id', $id)->first();
        if($act->status == "used") {
            $this->resetInputs();
            $this->emit('usedCriteria');
        } else {
            $tsk = GradeCriteria::where('id', $id)->delete();
            $this->resetInputs();
            $this->emit('criteriaDeleted');
        }
    }

    public function resetInputs()
    {
       $this->description = '';
       $this->selected_id = '';
       $this->deleteId = '';       
    }
}
