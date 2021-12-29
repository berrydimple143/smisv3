<?php

namespace App\Http\Livewire\InformationManagement;

use App\Models\StudentRecord;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;
use Carbon\Carbon;

class Student extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $course_id = '', $section_id= '';
    public $listOfStudents, $listOfSections;
    
    protected $listeners = ['resetInputs'];
    
    protected function rules() {
        return [
            'course_id' => ['required'],
            'section_id' => ['required'],
        ];
    }
    public function resetInputs()
    {
       $this->course_id = '';
       $this->section_id = '';
       $this->deleteId = '';
       $this->selected_id = '';
    }
    public function render()
    {
        
    	return view('livewire.information-management.student', [
            'students' => StudentRecord::where('course_id', $this->course_id)->where('section_id', $this->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');
    }
    public function updated() {
        $this->validate();
    }
    public function store()
    {
        $this->validate();
        $chosen = $this->chosen_id;
        if($chosen != "") {
            if(StudentSchoolYear::where('description', $this->description)->count() <= 0) {
                try {
                    $data = [
                        'description' => $this->description,
                        'start_date' => $this->start_date,
                        'end_date' => $this->end_date,
                    ];
                    DB::beginTransaction();            
                    $sy = StudentSchoolYear::create($data);
                    DB::commit();
                    $stat1 = $stat2 = $stat3 = null;
                    if($chosen == "1st") {
                        $stat1 = "active";
                    } else if($chosen == "2nd") {
                        $stat2 = "active";
                    } else if($chosen == "3rd") {
                        $stat3 = "active";
                    }
                    $sem1 = Semester::create(['description' => '1st Semester', 'school_year_id' => $sy->id, 'start_date' => $this->semester1_start_date, 'end_date' => $this->semester1_end_date, 'status' => $stat1]);
                    $sem2 = Semester::create(['description' => '2nd Semester', 'school_year_id' => $sy->id, 'start_date' => $this->semester2_start_date, 'end_date' => $this->semester2_end_date, 'status' => $stat2]);
                    $sem3 = Semester::create(['description' => '3rd Semester', 'school_year_id' => $sy->id, 'start_date' => $this->semester3_start_date, 'end_date' => $this->semester3_end_date, 'status' => $stat3]);
                    $this->resetInputs();
                    $this->emit('schoolyearCreated');
                } catch (Exception $e) {
                    DB::rollBack();
                    $this->emit('schoolyearFailed', $e->getMessage());
                    return $e->getMessage();
                }
            } else {
                $this->resetInputs();
                $this->emit('schoolyearExist');
            }
        } else {
            $this->emit('semesterNotSelected');
        }
    }
    public function edit($id) {
        
    }
    public function update() {
        
    }
    public function deleteThisId($id) {
        $this->deleteId = $id;
    }
    public function deleteNow() {
        
    }
}
