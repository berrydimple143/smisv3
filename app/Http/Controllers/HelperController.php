<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Criteria;
use App\Models\StudentRecord;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HelperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public static function convertArrayToString($arr, $delimeter) {
        $rolls = '';
        $cntr = $arr->count();
        if($cntr > 0) {
            for($i=0;$i<$cntr;$i++) {
                if($i == $cntr - 1) {
                    $rolls .= $arr[$i];    
                } else {
                    $rolls .= $arr[$i] .$delimeter.' ';
                }
            }
        }
        return $rolls;
    }
    public static function convertDateToString($date) {
        $newdate = new Carbon($date);
		return $newdate->toFormattedDateString();
    }
    public static function findAndTrim($data, $del) {
        $info = "";
        if(Str::contains($data, $del)) {
            $arr = explode($del, $data);    
            $str1 = trim($arr[0], " ");
            $str2 = trim($arr[1], " ");
            $info = $str1.$del.$str2;
        }
        return $info; 
    }
    public static function removePunctuations() {
        $numargs = func_num_args();
        $arg_list = func_get_args();
        $str = $arg_list[0];
        for ($i = 1; $i < $numargs; $i++) {
            $str = str_replace($arg_list[$i], "", $str);
        }
        return $str;
    }
    public static function getTotal($scores) {
        $total = 0;
        $cntr = 0;
        foreach($scores as $score) {
            $total += (($score->score/$score->item) * 50) + 50;
            $cntr++;
        }
        return $total/$cntr;
    }
    public static function getFieldValue($model, $field, $id) {
        if($model == "Course") {
            $singleModel = Course::find($id);
        } else if($model == "Section") {
            $singleModel = Section::find($id);
        } else if($model == "Subject") {
            $singleModel = Subject::find($id);
        } else if($model == "User") {
            $singleModel = User::find($id);
        } else if($model == "Criteria") {
            $singleModel = Criteria::find($id);
        } else if($model == "Classes") {
            $singleModel = Classes::find($id);
        } else if($model == "StudentRecord") {
            $singleModel = StudentRecord::find($id);
        }
        if($singleModel != null) {
            return $singleModel->$field;
        } else {
            return '';
        }
    }
}
