<?php

namespace App\Http\Livewire\Registrar;

use App\Models\Subject as StudentSubject;
use App\Models\Classification;
use App\Models\Course;

use Livewire\Component;
use App\Models\Assessment;
use Livewire\WithPagination;
use DB;
use Exception;

class Subject extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'created_at';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $code, $description, $lec_unit, $lab_unit, $pre_requisite_subject_id, $classification;
    public $listOfClassifications, $showInputs = false;    

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules() {
        return [            
            'description' => ['required', 'string'],            
            'code' => ['string', 'nullable'],
            'lec_unit' => ['string', 'nullable'],
            'lab_unit' => ['string', 'nullable'],            
            'classification' => ['required'],            
            'pre_requisite_subject_id' => ['nullable'],
        ];
    }

    public function render()
    {        
        $this->listOfClassifications = Classification::all();
        
        if(!empty($this->classification)) {            
            if($this->classification == 1) {           
                $this->showInputs = false;                
            } else {      
                $this->showInputs = true;                
            }
        }

        return view('livewire.registrar.subject', [
            'subjects' => StudentSubject::search($this->search)            
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')            
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }   

    public function store() {                     
        $this->validate();        
        try {                         
            $data = [
                'description' => $this->description,
                'code' => $this->code,
                'lec_unit' => $this->lec_unit,
                'lab_unit' => $this->lab_unit,               
                'classification_id' => $this->classification,
                'pre_requisite_subject_id' => $this->pre_requisite_subject_id,
            ];
            DB::beginTransaction();            
            $tsk = StudentSubject::create($data);
            DB::commit();                  
            $this->resetInputs();
            $this->emit('subjectCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('subjectFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit($id) {
        $subject = StudentSubject::where('id', $id)->first();
        $this->selected_id = $id;             
        $this->description = $subject->description;
        $this->code = $subject->code;        
        $this->lec_unit = $subject->lec_unit;
        $this->lab_unit = $subject->lab_unit;
        $this->classification = $subject->classification_id;   
        $this->pre_requisite_subject_id = $subject->pre_requisite_subject_id;
        if(!empty($this->classification)) {
            if($this->classification == 1) {                
                $this->showInputs = false;                
            } else {                
                $this->showInputs = true;               
            }
        }
    }

    public function update() {
        $this->validate([
            'description' => ['required', 'string'],            
            'code' => ['string', 'nullable'],
            'lec_unit' => ['string', 'nullable'],
            'lab_unit' => ['string', 'nullable'],            
            'pre_requisite_subject_id' => ['nullable'],
        ]);
        if ($this->selected_id) {
            try {               
                DB::beginTransaction();
                $data = [
                    'description' => $this->description,
                    'code' => $this->code,
                    'lec_unit' => $this->lec_unit,
                    'lab_unit' => $this->lab_unit,                         
                    'pre_requisite_subject_id' => $this->pre_requisite_subject_id,
                ];  
                $upd = StudentSubject::where('id', $this->selected_id)->update($data);
                DB::commit();                      
                $this->resetInputs();
                $this->emit('subjectUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('subjectFailed', $e->getMessage());
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
        $act = StudentSubject::where('id', $id)->first();
        if($act->used == "yes") {
            $this->resetInputs();
            $this->emit('usedSubject');
        } else {
            $tsk = StudentSubject::where('id', $id)->delete();
            $this->resetInputs();
            $this->emit('subjectDeleted');
        }
    }

    public function resetInputs()
    {
       $this->description = '';
       $this->code = '';
       $this->lec_unit = '';
       $this->lab_unit = '';   
       $this->classification = '';
       $this->pre_requisite_subject_id = '';              
       $this->showInputs = false;
    }

}
