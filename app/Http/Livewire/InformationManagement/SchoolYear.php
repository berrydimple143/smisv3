<?php

namespace App\Http\Livewire\InformationManagement;

use App\Models\SchoolYear as StudentSchoolYear;
use App\Models\Semester;

use Livewire\Component;
use App\Models\Assessment;
use Livewire\WithPagination;
use DB;
use Exception;
use Carbon\Carbon;
use App\Http\Controllers\HelperController;

class SchoolYear extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId, $chosen_id = '', $mode = 'add';
    public $description, $start_date, $end_date;
    public $semester1_start_date, $semester2_start_date, $semester3_start_date;
    public $semester1_end_date, $semester2_end_date, $semester3_end_date;
    public $stat_btn_txt = "Activate", $stat_btn_style = "success", $status_chosen_id;
    public $stat_modal_content = "The status is inactive at the moment. Please activate using the button below:";
    
    protected $listeners = ['addSemesterValue', 'changeStatus'];
    
    protected function rules() {
        return [
            'description' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'semester1_start_date' => ['required', 'date'],
            'semester2_start_date' => ['required', 'date'],
            'semester3_start_date' => ['required', 'date'],
            'semester1_end_date' => ['required', 'date'],
            'semester2_end_date' => ['required', 'date'],
            'semester3_end_date' => ['required', 'date'],
        ];
    }
    public function resetInputs()
    {
       $this->description = '';
       $this->start_date = '';
       $this->end_date = '';
       $this->mode = 'add';
       $this->semester1_start_date = '';
       $this->semester2_start_date = '';
       $this->semester3_start_date = '';
       $this->semester1_end_date = '';
       $this->semester2_end_date = '';
       $this->semester3_end_date = '';
       $this->chosen_id = '';
       $this->deleteId = '';   
       $this->selected_id = '';
       $this->emit("resetCheckbox");
    }
    public function render()
    {
    	return view('livewire.information-management.school-year', [
            'schoolyears' => StudentSchoolYear::search($this->search)
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
            $desc = $this->description;
            $clean = HelperController::findAndTrim($desc, '-');
            if($clean != "") {
                if(StudentSchoolYear::where('description', $clean)->count() <= 0) {
                    try {
                        $data = [
                            'description' => $clean,
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
                $this->emit('invalidFormat');
            }
        } else {
            $this->emit('semesterNotSelected');
        }
    }
    public function addSemester($id) {
        $this->emit('semesterValue', $id);
    }
    public function changeStatus($id) {
        $this->status_chosen_id = $id;
        $scyear = StudentSchoolYear::where('id', $id)->first();
        if($scyear->status == 1 or $scyear->status == '1') {
		    $this->stat_modal_content = "The status is already active. If you want to de-activate it, please click the button below:";
            $this->stat_btn_style = "danger";
            $this->stat_btn_txt = "De-activate";
		} else {
		    $this->stat_modal_content = "The status is inactive at the moment. Please activate using the button below:";
            $this->stat_btn_style = "success";
            $this->stat_btn_txt = "Activate";
		}
    }
    public function changeNow() {
        $sy = StudentSchoolYear::query()->update(['status' => 0]);
        $scyear = StudentSchoolYear::where('id', $this->status_chosen_id)->first();
        $systatus = 1;
        if($scyear->status == 1 or $scyear->status == '1') { $systatus = 0; }
        $scyear = StudentSchoolYear::where('id', $this->status_chosen_id)->update(['status' => $systatus]);
        $this->resetInputs();
        $this->emit('schoolyearStatusUpdated');
    }
    public function addSemesterValue($value) {
        $this->chosen_id = $value;
    }
    public function edit($id) {
        $this->selected_id = $id;
        $this->mode = 'edit';
        $scyear = StudentSchoolYear::where('id', $id)->first();
        $sem1 = Semester::where('school_year_id', $id)->where('description', '1st Semester')->first();
        $sem2 = Semester::where('school_year_id', $id)->where('description', '2nd Semester')->first();
        $sem3 = Semester::where('school_year_id', $id)->where('description', '3rd Semester')->first();
        $this->start_date = Carbon::parse($scyear->start_date)->format('Y-m-d');
        $this->end_date = Carbon::parse($scyear->end_date)->format('Y-m-d');
        $this->description = $scyear->description;
        $this->semester1_start_date = Carbon::parse($sem1->start_date)->format('Y-m-d');
        $this->semester2_start_date = Carbon::parse($sem2->start_date)->format('Y-m-d');
        $this->semester3_start_date = Carbon::parse($sem3->start_date)->format('Y-m-d');
        $this->semester1_end_date = Carbon::parse($sem1->end_date)->format('Y-m-d');
        $this->semester2_end_date = Carbon::parse($sem2->end_date)->format('Y-m-d');
        $this->semester3_end_date = Carbon::parse($sem3->end_date)->format('Y-m-d');
        $stat = "";
        if($sem1->status == "active") { 
            $stat = "semester1"; 
        } else if($sem2->status == "active") {
            $stat = "semester2"; 
        } else if($sem3->status == "active") {
            $stat = "semester3"; 
        }
        $this->emit('checkSemester', $stat);
    }
    public function update() {
        $this->validate();
        $chosen = $this->chosen_id;
        $selected = $this->selected_id;
        if($chosen != "") {
            try {
                $data = [
                    'description' => $this->description,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                ];
                DB::beginTransaction();            
                $sy = StudentSchoolYear::where('id', $selected)->update($data);
                DB::commit();
                $stat1 = $stat2 = $stat3 = null;
                if($chosen == "1st") {
                    $stat1 = "active";
                } else if($chosen == "2nd") {
                    $stat2 = "active";
                } else if($chosen == "3rd") {
                    $stat3 = "active";
                }
                $sem1 = Semester::where('school_year_id', $selected)->where('description', '1st Semester')->update(['start_date' => $this->semester1_start_date, 'end_date' => $this->semester1_end_date, 'status' => $stat1]);
                $sem2 = Semester::where('school_year_id', $selected)->where('description', '2nd Semester')->update(['start_date' => $this->semester2_start_date, 'end_date' => $this->semester2_end_date, 'status' => $stat2]);
                $sem3 = Semester::where('school_year_id', $selected)->where('description', '3rd Semester')->update(['start_date' => $this->semester3_start_date, 'end_date' => $this->semester3_end_date, 'status' => $stat3]);
                $this->resetInputs();
                $this->emit('schoolyearUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('schoolyearFailed', $e->getMessage());
                return $e->getMessage();
            }
        } else {
            $this->emit('semesterNotSelected');
        }
    }
    public function deleteThisId($id) {
        $this->deleteId = $id;
    }
    public function deleteNow() {
        $sem = Semester::where('school_year_id', $this->deleteId)->delete();
        $sem = StudentSchoolYear::where('id', $this->deleteId)->delete();
        $this->resetInputs();
        $this->emit('schoolyearDeleted');
    }
}
