<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    protected $table = 'summative_assessment';

    protected $fillable = [
        'type',
        'SA1',
        'SA2',
        'SA3',
        'SA4',
        'SA5',
        'SA6',
        'SA7',
        'SA8'
    ];
    
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('SA1', 'like', '%'.$search.'%')
                ->orWhere('SA2', 'like', '%'.$search.'%')
                ->orWhere('SA3', 'like', '%'.$search.'%')
                ->orWhere('SA4', 'like', '%'.$search.'%')
                ->orWhere('SA5', 'like', '%'.$search.'%')
                ->orWhere('SA6', 'like', '%'.$search.'%')
                ->orWhere('SA7', 'like', '%'.$search.'%')
                ->orWhere('SA8', 'like', '%'.$search.'%');
    }
}
