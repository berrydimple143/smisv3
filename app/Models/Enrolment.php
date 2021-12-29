<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $table = 'enrolment';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'student_record_id', 'college_id', 'course_id', 'level_id', 'curriculum_id', 'school_year_id', 'term_id', 'status', 'term_of_payment_id', 'total', 'tuition', 'miscellaneous', 'discount', 'classification_id', 'type'
    ];


    public function studentrecord()
    {
        return $this->hasOne('App\Models\StudentRecord','id', 'student_record_id');
    }

}
