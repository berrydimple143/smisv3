<?php

namespace App\Http\Livewire\Grading;

use Livewire\Component;
use App\Models\Task;
use Livewire\WithPagination;
use DB;
use Exception;

class PerformanceTask extends Component
{
	use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;
    public $selected_id, $deleteId;
    public $MT1, $MT2, $MT3, $PT, $type;

    protected function rules(){
        return [
            'MT1' => ['required', 'numeric'],
            'MT2' => ['required', 'numeric'],
            'MT3' => ['required', 'numeric'],
            'PT' => ['required', 'numeric'],            
            'type' => ['required', 'string'],
        ];
    }

    public function resetInputs()
    {
       $this->MT1 = '';
       $this->MT2 = '';
       $this->MT3 = '';
       $this->PT = '';   
       $this->type = '';
    }

    public function render()
    {
    	return view('livewire.grading.performance-task', [
            'tasks' => Task::search($this->search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');        
    }

    public function store() {
        $this->validate();
        $data = [
            'MT1' => $this->MT1,
            'MT2' => $this->MT2,
            'MT3' => $this->MT3,
            'PT' => $this->PT,            
            'type' => $this->type
        ];
        try {
            DB::beginTransaction();
            $tsk = Task::create($data);
            DB::commit();
            $this->resetInputs();
            $this->emit('taskCreated');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('taskFailed', $e->getMessage());
            return $e->getMessage();
        }
    }

    public function edit($id)
    {           
        $task = Task::where('id',$id)->first();
        $this->selected_id = $id;
        $this->MT1 = $task->MT1;
        $this->MT2 = $task->MT2;
        $this->MT3 = $task->MT3;
        $this->PT = $task->PT;
        $this->type = $task->type;        
    }

    public function update()
    {
        $this->validate();
        if ($this->selected_id) {
            $tsk = Task::find($this->selected_id);
            try {
                DB::beginTransaction();
                $tsk->update([
                    'MT1' => $this->MT1,
                    'MT2' => $this->MT2,
                    'MT3' => $this->MT3,
                    'PT' => $this->PT,                    
                    'type' => $this->type,
                ]);         
                DB::commit();
                $this->resetInputs();
                $this->emit('taskUpdated');
            } catch (Exception $e) {
                DB::rollBack();
                $this->emit('taskFailed', $e->getMessage());
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
        $tsk = Task::where('id', $this->deleteId)->delete();
        $this->emit('taskDeleted');
    }
}
