<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingSystem extends Model
{
    use HasFactory;
    protected $table = 'grading_system';

    protected $fillable = [    
        'user_id',
        'course_id',
        'section_id',
        'subject_id',       
        'selected'
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')     
                ->orWhere('user_id', 'like', '%'.$search.'%')   
            	->orWhere('course_id', 'like', '%'.$search.'%')       
                ->orWhere('section_id', 'like', '%'.$search.'%')    
                ->orWhere('subject_id', 'like', '%'.$search.'%');
    }

    public function gradecriterias()
    {
        return $this->hasMany(GradeCriteria::class, 'grading_system_id', 'id');
    }

}
