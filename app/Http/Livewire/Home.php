<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\StudentStatus;
use App\Models\StudentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public function render()
    {
    	if(Auth::user()->type == "student"){
            $studentRecord = StudentRecord::where('id', Auth::user()->account_id)->first();
            $status = $studentRecord->status;
        }else{
            $studentRecord = '';
            $status = '';
        }

        $faculty = DB::table('faculty_record')->count();
        $students = DB::table('student_record')->count();
        $subject = DB::table('subject')->count();

        // students
        $new = DB::table('student_record')->where("status",1)->count();
        $transferees = DB::table('student_record')->where("status",3)->count();
        $old = DB::table('student_record')->where("status",2)->count();

        $data=[
            "faculty"=>$faculty,
            "students"=>$students,
            "subject"=>$subject,
            "new"=>$new,
            "transferees"=>$transferees,
            "old"=>$old,
            "info"=>$studentRecord,
            "status"=>$status,
        ];
        
        return view('livewire.home', ["data"=> $data])->extends('layouts.app');
    }
}
