<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemesterRegistration extends Model
{
    protected $table = 'semester_registration';

    protected $fillable = [
        'student_record_id',
        'school_year_id',
        'term_id',
        'limit',
        'level_id',
        'classification_id',
        'college_id',
        'course_id',
        'curriculum_id',
        'status_id',
        'creditation_approval',
        'creditation_approve_by'
    ];

}
