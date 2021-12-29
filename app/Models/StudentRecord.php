<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StudentRecord extends Model
{
    protected $table = 'student_record';

    protected $fillable = [
        'lrn',
        'student_number',
        'reference_number',
        'status',
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'citizenship_id',
        'religion_id',
        'date_of_birth',
        'civil_status',
        'email',
        'contact_number',
        'current_address',
        'permanent_address',
        'father_last_name',
        'father_first_name',
        'father_middle_name',
        'father_occupation',
        'father_ext_name',
        'father_contact',
        'father_barangay',
        'father_street',
        'father_municipality',
        'father_provice',
        'mother_last_name',
        'mother_first_name',
        'mother_middle_name',
        'mother_occupation',
        'mother_ext_name',
        'mother_contact',
        'mother_barangay',
        'mother_street',
        'mother_municipality',
        'mother_province',
        'guardian_last_name',
        'guardian_first_name',
        'guardian_middle_name',
        'guardian_contact_number',
        'guardian_relation',
        'guardian_ext_name',
        'guardian_barangay',
        'guardian_street',
        'guardian_municipality',
        'guardian_provice',
        'guardian_occupation',
        'admission_date',
        'blood_type',
        'height',
        'weight',
        'course_id',
        'section_id',
        'curriculum_id',
        'photo',
        'birth'
    ];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('first_name', 'like', '%'.$search.'%')
                ->orWhere('last_name', 'like', '%'.$search.'%')
                ->orWhere('middle_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
    }

    public function student() {
//        return $this->hasOne('App\Models\User','account_id','id');
        return $this->belongsTo('App\Models\User','id','account_id');
    }

    public function course() {
        return $this->hasOne('App\Models\Course','id','course_id');
    }

    public function StudentStatus(){
        return $this->hasOne('App\Models\StudentStatus','id','status');
    }

    public function enrolment()
    {
        return $this->hasOne('App\Models\Enrolment','student_record_id','id');
    }

    public function creditedsubject()
    {
        return $this->hasMany('App\Models\CreditedSubject','student_record_id','id');
    }

    public function getEnrolmentCountAttribute()
    {
        return $this->hasOne('App\Models\Enrolment','student_record_id','id')->count();
    }

    public function getCreditedCountAttribute()
    {
//        return $this->hasOne('App\Models\Enrolment','student_record_id','id')->count();
        return $this->hasMany('App\Models\CreditedSubject','student_record_id','id')->count();
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAdmissionDateNameAttribute()
    {
        return Carbon::parse($this->attributes['admission_date'])->format('M d Y');
    }

}


