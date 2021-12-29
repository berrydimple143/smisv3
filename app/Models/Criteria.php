<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;
    protected $table = 'criteria';

    protected $fillable = [    
        'description',          
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')                
                ->orWhere('created_at', 'like', '%'.$search.'%');
    }
}
