<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';

    protected $fillable = [    
    	'section_id',        
        'subject_id',
        'teacher_id',        
        'course_id',
        'school_year_id',        
        'semester_id',
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('section_id', 'like', '%'.$search.'%')   
                ->orWhere('subject_id', 'like', '%'.$search.'%')       
                ->orWhere('teacher_id', 'like', '%'.$search.'%')   
                ->orWhere('course_id', 'like', '%'.$search.'%') 
                ->orWhere('school_year_id', 'like', '%'.$search.'%')   
                ->orWhere('semester_id', 'like', '%'.$search.'%') 
                ->orWhere('created_at', 'like', '%'.$search.'%');
    }
}
