<?php

namespace App\Http\Livewire\Registrar;

use App\Models\StudentRecord;
use App\Models\Section;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class SectionStudent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'first_name';
    public $orderAsc = true;
    public $deleteId;
    public $section_id, $student_id;
    public $listOfStudents;
    
    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules() {
        return [
            'student_id' => ['required'],
        ];
    }

    public function resetInputs()
    {
       $this->student_id = '';       
       $this->deleteId = '';
    }

    public function mount($id) {
        $this->section_id = $id;
    }

    public function render()
    {
        $section = Section::where('id', $this->section_id)->first();        
        $this->listOfStudents = StudentRecord::orderBy('last_name')->get();  
    	return view('livewire.registrar.section-student', [
            'sectionName' => $section->name,
            'section_id' => $this->section_id,
            'students' => StudentRecord::where('section_id', $this->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }
    
    public function store() {
        $this->validate();
        $secID = $this->section_id;
        $clID = $this->student_id;
        $student = StudentRecord::where('id', $clID)->first();
        if(empty($student->section_id) or $student->section_id == "" or $student->section_id == null) {
            if(StudentRecord::where('section_id', $secID)->where('id', $clID)->count() > 0) {
                $this->resetInputs();
                $this->emit('studentAlreadyExist');
            } else {
                try {
                    DB::beginTransaction();            
                    $tsk = StudentRecord::where('id', $clID)->update(['section_id' => $secID]);
                    DB::commit();                           
                    $this->resetInputs();
                    $this->emit('studentSectionCreated');
                } catch (Exception $e) {
                    DB::rollBack();
                    $this->emit('studentSectionFailed', $secID);
                    return $e->getMessage();
                }
            }
        } else {
            $this->resetInputs();
            $this->emit('studentHasSection');
        }
    }
    
    public function viewGrades($id) {
        return redirect()->route('student.grades', ['student_id' => $id, 'section_id' => $this->section_id]);
    }

    public function deleteThisId($id)
    {
        $this->deleteId = $id;
    }
    
    public function deleteNow()
    {   
        $clAct = StudentRecord::where('id', $this->deleteId)->update(['section_id' => null]);
        $this->emit('studentSectionDeleted');
    }

}
