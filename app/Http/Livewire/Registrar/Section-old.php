<?php

namespace App\Http\Livewire\Registrar;

use App\Models\Section as UserSection;
use App\Models\User;
use App\Models\Subject;
use App\Models\GradingSystem;
use App\Models\SectionActivity;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class Section extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $name, $offered_subject_id, $user_id, $student_limit, $color, $grading_system_id;
    public $listOfTeachers, $listOfSubjects, $listOfGradingSystems;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules(){
        return [
            'name' => ['required'],
            'user_id' => ['required'],
            'offered_subject_id' => ['required'],
            'grading_system_id' => ['required'],
            'student_limit' => ['nullable'],
            'color' => ['nullable'],            
        ];
    }

    public function resetInputs()
    {
       $this->name = '';
       $this->offered_subject_id = '';
       $this->grading_system_id = '';
       $this->user_id = '';
       $this->student_limit = '';   
       $this->color = '';
    }

    public function render()
    {
        $this->listOfTeachers = User::all();
        $this->listOfGradingSystems = GradingSystem::all();
        $this->listOfSubjects = Subject::orderBy('created_at', 'desc')->get();
    	return view('livewire.registrar.section', [            
            'sections' => UserSection::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');          
    }

    public function store() {                      
        $this->validate();        
        try {
            $data = [
                'name' => $this->name,
                'offered_subject_id' => $this->offered_subject_id,
                'grading_system_id' => $this->grading_system_id,
                'user_id' => $this->user_id,            
                'student_limit' => $this->student_limit,
                'color' => $this->color,
            ];
            DB::beginTransaction();            
            $tsk = UserSection::create($data);
            $subj = Subject::where('id', $this->offered_subject_id)->update(['used' => 'yes']);
            $grdsys = GradingSystem::where('id', $this->grading_system_id)->update(['selected' => 'yes']);
            DB::commit();                           
            $this->resetInputs();
            $this->emit('sectionCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('sectionFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function activities($id) {
        return redirect()->route('section.activities', ['id' => $id]);
    }

    public function edit($id)
    {   
        $section = UserSection::where('id',$id)->first();
        $this->selected_id = $id;
        $this->name = $section->name;
        $this->offered_subject_id = $section->offered_subject_id;
        $this->grading_system_id = $section->grading_system_id;
        $this->user_id = $section->user_id;
        $this->student_limit = $section->student_limit;     
        $this->color = $section->color;      
    }

    public function update()
    {
        $this->validate();
        if($this->selected_id) {
            $sect = UserSection::find($this->selected_id);
            try {
                DB::beginTransaction();
                $sect->update([
                    'name' => $this->name,
                    'offered_subject_id' => $this->offered_subject_id,
                    'grading_system_id' => $this->grading_system_id,
                    'user_id' => $this->user_id,                    
                    'student_limit' => $this->student_limit,
                    'color' => $this->color,
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('sectionUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('sectionFailed', $e->getMessage());
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
        $usrsec = UserSection::where('id', $id)->first();
        $subj = Subject::where('id', $usrsec->offered_subject_id)->update(['used' => 'no']);
        $grdsys = GradingSystem::where('id', $usrsec->grading_system_id)->update(['selected' => 'no']);
        $sa = SectionActivity::where('section_id', $id)->delete();
        $us = UserSection::where('id', $id)->delete();
        $this->emit('sectionDeleted');
    }
}
