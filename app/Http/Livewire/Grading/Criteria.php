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
    public $selected_id, $deleteId, $status_chosen_id;
    public $description, $percent, $active;
    public $stat_modal_content = "The status is inactive at the moment. Please activate using the button below:";
    public $stat_btn_txt = "Activate", $stat_btn_style = "success";

    protected $listeners = ['resetInputs', 'changeCriteriaStatus'];

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
    
    public function changeCriteriaStatus($id) {
        $this->status_chosen_id = $id;
        $grcr = GradeCriteria::where('id', $id)->first();
        if($grcr->active == 'yes') {
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
        $grcr = GradeCriteria::where('id', $this->status_chosen_id)->first();
        $systatus = 'yes';
        if($grcr->active == 'yes') { $systatus = 'no'; }
        $grcr = GradeCriteria::where('id', $this->status_chosen_id)->update(['active' => $systatus]);
        $this->resetInputs();
        $this->emit('criteriaStatusUpdated');
    }

    public function edit($id)
    {   
        $criteria = GradeCriteria::where('id', $id)->first();
        $this->selected_id = $id;
        $this->description = $criteria->description;   
        $this->active = $criteria->active;   
        $this->percent = $criteria->percent;   
    }

    public function update()
    {
        $this->validate([
            'description' => ['required', 'string'],
            'percent' => ['required', 'integer'],
            'active' => ['required'],
        ]);
        if($this->checkLimit($this->percent, $this->active, $this->selected_id) == "ok") {
            if($this->selected_id) {
                $act = GradeCriteria::find($this->selected_id);
                try {
                    DB::beginTransaction();
                    $act->update([
                        'description' => $this->description,
                        'percent' => $this->percent,
                        'active' => $this->active,
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
        } else {
            $this->resetInputs();
            $this->emit('percentExceeded');
        }
    }
    private function checkLimit($percent, $active, $id) {
        $limit = "ok";
        if($active == "yes") {
            $cntr = GradeCriteria::where('id', '!=', $id)->sum('percent');
            $total = (int)$percent + $cntr;
            if($total > 100) {
                $limit = "exceeded";
            }
        }
        return $limit;
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
       $this->percent = '';
       $this->selected_id = '';
       $this->deleteId = '';       
    }
}
