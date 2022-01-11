<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectCriteria extends Model
{
    use HasFactory;
    protected $table = 'subject_criteria';

    protected $fillable = [
    	'description',        
        'criteria_id',
        'subject_id',        
        'course_id',
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')   
                ->orWhere('criteria_id', 'like', '%'.$search.'%')        
                ->orWhere('subject_id', 'like', '%'.$search.'%')
                ->orWhere('course_id', 'like', '%'.$search.'%')
                ->orWhere('created_at', 'like', '%'.$search.'%');
    }
}
