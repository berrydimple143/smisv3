<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditedSubject extends Model
{
//    protected $table = 'fee';
    protected $fillable = [
        'student_record_id', 'subject_id', 'grade'
    ];
}
