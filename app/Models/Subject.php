<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subject';

    protected $fillable = [    
        'description',
        'code',
        'lec_unit',
        'lab_unit',
        'course_id',
        'classification_id',
        'pre_requisite_subject_id'
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('code', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('lec_unit', 'like', '%'.$search.'%')
                ->orWhere('lab_unit', 'like', '%'.$search.'%');
    }

}
