<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'description',
        'school_year_id',
        'start_date',
        'end_date',
        'status',
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('school_year_id', 'like', '%'.$search.'%')
                ->orWhere('created_at', 'like', '%'.$search.'%');                
    }
}
