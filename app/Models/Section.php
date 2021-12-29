<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = 'section';

    protected $fillable = [    
        'name',        
        'course_id',
        'student_limit',
        'color'        
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('student_limit', 'like', '%'.$search.'%')
                ->orWhere('created_at', 'like', '%'.$search.'%')
                ->orWhere('color', 'like', '%'.$search.'%');
    }

    public function sectionactivites()
    {
        return $this->hasMany(SectionActivity::class, 'section_id', 'id');
    }
    
    public function sectionstudents()
    {
        return $this->hasMany(StudentRecord::class, 'section_id', 'id');
    }
    
    public function sectionsubjects()
    {
        return $this->hasMany(SectionSubject::class, 'section_id', 'id');
    }
}
