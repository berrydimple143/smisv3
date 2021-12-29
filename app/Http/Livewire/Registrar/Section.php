<?php

namespace App\Http\Livewire\Registrar;

use App\Models\Section as UserSection;
use App\Models\User;
use App\Models\Course;
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
    public $name, $student_limit, $color, $course_id;
    public $listOfLevels;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];

    protected function rules(){
        return [
            'name' => ['required'],      
            'course_id' => ['required'],        
            'student_limit' => ['nullable'],
            'color' => ['nullable'],            
        ];
    }

    public function resetInputs()
    {
       $this->name = '';       
       $this->course_id = '';    
       $this->student_limit = '';   
       $this->color = '';
    }

    public function render()
    {        
        $this->listOfLevels = Course::orderBy('name')->get();
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
                'course_id' => $this->course_id,           
                'student_limit' => $this->student_limit,
                'color' => $this->color,
            ];
            DB::beginTransaction();            
            $tsk = UserSection::create($data);           
            DB::commit();                           
            $this->resetInputs();
            $this->emit('sectionCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('sectionFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function students($id) {
        return redirect()->route('section.students', ['id' => $id]);
    }
    
    public function subjects($id) {
        return redirect()->route('section.subjects', ['id' => $id]);
    }

    public function edit($id)
    {   
        $section = UserSection::where('id',$id)->first();
        $this->selected_id = $id;
        $this->name = $section->name;     
        $this->course_id = $section->course_id;      
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
                    'course_id' => $this->course_id,            
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
        $sa = SectionActivity::where('section_id', $id)->delete();
        $us = UserSection::where('id', $id)->delete();
        $this->emit('sectionDeleted');
    }
}
