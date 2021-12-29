<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeCriteria extends Model
{
    use HasFactory;
    protected $table = 'grade_criteria';

    protected $fillable = [    
        'criteria_id',                
        'grading_system_id', 
        'percent',
    ];    

    public function gradingsystem()
    {
        return $this->belongsTo(GradingSystem::class, 'grading_system_id', 'id');        
    }

}
