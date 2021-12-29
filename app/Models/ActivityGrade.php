<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityGrade extends Model
{
    use HasFactory;
    protected $table = 'activity_grade';

    protected $fillable = [    
    	'section_id',        
        'subject_id',
        'student_id',        
        'activity_id',
        'item',        
        'score',
        'activity_number',
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('section_id', 'like', '%'.$search.'%')   
                ->orWhere('subject_id', 'like', '%'.$search.'%')              
                ->orWhere('created_at', 'like', '%'.$search.'%');
    }
    
}
