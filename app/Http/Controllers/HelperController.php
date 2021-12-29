<?php

namespace App\Http\Controllers;

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
}
