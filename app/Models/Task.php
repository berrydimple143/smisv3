<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'performance_task';

    protected $fillable = [
        'type',
        'MT1',
        'MT2',
        'MT3',
        'PT'        
    ];
    
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('MT1', 'like', '%'.$search.'%')                
                ->orWhere('MT2', 'like', '%'.$search.'%')
                ->orWhere('MT3', 'like', '%'.$search.'%')                
                ->orWhere('PT', 'like', '%'.$search.'%');
    }
}
