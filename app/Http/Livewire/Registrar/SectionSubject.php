<?php

namespace App\Http\Livewire\Registrar;

use App\Models\SectionSubject as StudentSubject;
use App\Models\Subject;
use App\Models\Section;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class SectionSubject extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'created_at';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $section_id, $subject_id;
    public $listOfSubjects;
    
    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules(){
        return [
            'subject_id' => ['required'],
        ];
    }
    
    public function mount($id) {
        $this->section_id = $id;
    }
    
    public function resetInputs()
    {
       $this->subject_id = '';
       $this->deleteId = '';   
       $this->selected_id = '';
    }
    
    public function render()
    {
        $section = Section::where('id', $this->section_id)->first();
        $this->listOfSubjects = Subject::orderBy('description')->get();
    	return view('livewire.registrar.section-subject', [    
    	    'section' => $section,
            'subjects' => StudentSubject::where('section_id', $this->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');          
    }

    public function store() {                     
        $this->validate();        
        if(StudentSubject::where('subject_id', $this->subject_id)->where('section_id', $this->section_id)->count() <= 0) {
            try {
                $data = [
                    'subject_id' => $this->subject_id,      
                    'section_id' => $this->section_id,           
                ];
                DB::beginTransaction();            
                $tsk = StudentSubject::create($data);           
                DB::commit();                           
                $this->resetInputs();
                $this->emit('sectionSubjectCreated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('sectionSubjectFailed', $this->section_id);
                return $e->getMessage();
            }
        } else {
            $this->resetInputs();
            $this->emit('sectionSubjectExist');
        }
    }
    
    public function activities($subjectId, $sectionId) {
        return redirect()->route('subject.activities', ['subjectId' => $subjectId, 'sectionId' => $sectionId]);
    }

    public function deleteThisId($id)
    {
        $this->deleteId = $id;
    }
    
    public function deleteNow()
    {   
        $sa = StudentSubject::where('id', $this->deleteId)->delete();
        $this->emit('sectionSubjectDeleted');
    }
    
}
