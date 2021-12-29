<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;
    protected $table = 'school_year';

    protected $fillable = [    
        'description',        
        'start_date',
        'end_date',
        'status',
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('start_date', 'like', '%'.$search.'%')
                ->orWhere('end_date', 'like', '%'.$search.'%')
                ->orWhere('created_at', 'like', '%'.$search.'%');
    }
}
