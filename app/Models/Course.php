<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';

    protected $fillable = [
        'code',
        'name',
        'classification_id',
        'college_id'
    ];

    public function classification(){
        return $this->hasOne('App\Models\Classification','id','classification_id');
    }

    public function college() {
        return $this->hasOne('App\Models\College','id','college_id');
    }

    public function subjects() {
        return $this->belongsToMany(Subject::class);
    }

}
