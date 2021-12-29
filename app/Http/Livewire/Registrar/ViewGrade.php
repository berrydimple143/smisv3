<?php

namespace App\Http\Livewire\Registrar;

use App\Models\ClassActivity;
use App\Models\Subject;
use App\Models\Section;
use App\Models\SectionSubject;
use App\Models\StudentRecord;
use App\Models\ActivityGrade;

use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Exception;

class ViewGrade extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;
    public $deleteId;
    public $student_id, $section_id, $subject_id, $activity_id, $item, $score;

    protected $listeners = ['resetAllInputs' => 'resetInputs'];
    
    public function resetInputs()
    {
       $this->item = '';     
       $this->score = '';     
       $this->deleteId = '';
    }

    public function mount($studentId, $sectionId, $subjectId, $activityId) {
        $this->student_id = $studentId;
        $this->section_id = $sectionId;
        $this->subject_id = $subjectId;
        $this->activity_id = $activityId;
    }

    public function render()
    {
        $secsub = SectionSubject::where('section_id', $this->section_id)->where('subject_id', $this->subject_id)->first();
    	return view('livewire.registrar.view-grade', [
    	    'student' => StudentRecord::where('id', $this->student_id)->first(),
            'subject' => Subject::where('id', $this->subject_id)->first(),
            'section' => Section::where('id', $this->section_id)->first(),
            'ssid' => $secsub->id,
            'activity' => ClassActivity::where('id', $this->activity_id)->first(),
            'grades' => ActivityGrade::where('activity_id', $this->activity_id)->where('student_id', $this->student_id)
                                      ->where('subject_id', $this->subject_id)->where('section_id', $this->section_id)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage),
        ])->extends('layouts.app');          
    }
    
    public function deleteThisId($id)
    {
        $this->deleteId = $id;
    }
    
    public function deleteNow()
    {   
        $sa = ActivityGrade::where('id', $this->deleteId)->delete();
        $this->emit('activityGradeDeleted');
    }
}
