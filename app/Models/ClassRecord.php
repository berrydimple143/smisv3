<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRecord extends Model
{
    use HasFactory;
    protected $table = 'class_record';

    protected $fillable = [
    	'school_year_id',        
        'semester_id',
        'quarter_id',        
        'course_id',
        'section_id',        
        'teacher_id',
        'subject_id',
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('school_year_id', 'like', '%'.$search.'%')   
                ->orWhere('semester_id', 'like', '%'.$search.'%')       
                ->orWhere('quarter_id', 'like', '%'.$search.'%')   
                ->orWhere('section_id', 'like', '%'.$search.'%') 
                ->orWhere('teacher_id', 'like', '%'.$search.'%')   
                ->orWhere('subject_id', 'like', '%'.$search.'%') 
                ->orWhere('created_at', 'like', '%'.$search.'%');
    }
}
