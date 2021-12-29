<?php

namespace App\Http\Livewire\Grading;

use Livewire\Component;
use App\Models\Assessment;
use Livewire\WithPagination;
use DB;
use Exception;

class SummativeAssessment extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $SA1, $SA2, $SA3, $SA4, $SA5, $SA6, $SA7, $SA8, $type;
    
    protected function rules(){
        return [
            'SA1' => ['required', 'numeric'],
            'SA2' => ['required', 'numeric'],
            'SA3' => ['required', 'numeric'],
            'SA4' => ['required', 'numeric'],
            'SA5' => ['required', 'numeric'],
            'SA6' => ['required', 'numeric'],
            'SA7' => ['required', 'numeric'],
            'SA8' => ['required', 'numeric'],
            'type' => ['required', 'string'],
        ];
    }
    
    public function render()
    {
        return view('livewire.grading.summative-assessment', [
            'assessments' => Assessment::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }
    
    public function store() {
        $this->validate();
        $data = [
            'SA1' => (int)$this->SA1,
            'SA2' => (int)$this->SA2,
            'SA3' => (int)$this->SA3,
            'SA4' => (int)$this->SA4,
            'SA5' => (int)$this->SA5,
            'SA6' => (int)$this->SA6,
            'SA7' => (int)$this->SA7,
            'SA8' => (int)$this->SA8,
            'type' => $this->type
        ];
        try {
            DB::beginTransaction();
            $assessment = Assessment::create($data);
            DB::commit();
            $this->resetInputs();
            $this->emit('assessmentCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('assessmentFailed', $e->getMessage());
            return $e->getMessage();
        }
    }
    
    public function resetInputs()
    {
       $this->SA1 = '';
       $this->SA2 = '';
       $this->SA3 = '';
       $this->SA4 = '';
       $this->SA5 = '';
       $this->SA6 = '';
       $this->SA7 = '';
       $this->SA8 = '';
       $this->type = '';
    }

    public function edit($id)
    {           
        $assmt = Assessment::where('id',$id)->first();
        $this->selected_id = $id;
        $this->SA1 = $assmt->SA1;
        $this->SA2 = $assmt->SA2;
        $this->SA3 = $assmt->SA3;
        $this->SA4 = $assmt->SA4;
        $this->SA5 = $assmt->SA5;
        $this->SA6 = $assmt->SA6;
        $this->SA7 = $assmt->SA7;
        $this->SA8 = $assmt->SA8;
        $this->type = $assmt->type;        
    }

    public function update()
    {
        $this->validate();
        if ($this->selected_id) {
            $assmt = Assessment::find($this->selected_id);
            try {
                DB::beginTransaction();
                $assmt->update([
                    'SA1' => $this->SA1,
                    'SA2' => $this->SA2,
                    'SA3' => $this->SA3,
                    'SA4' => $this->SA4,
                    'SA5' => $this->SA5,
                    'SA6' => $this->SA6,
                    'SA7' => $this->SA7,
                    'SA8' => $this->SA8,
                    'type' => $this->type,
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('assessmentUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('assessmentFailed', $e->getMessage());
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
        $assessment = Assessment::where('id', $this->deleteId)->delete();
        $this->emit('assessmentDeleted');
    }

}
