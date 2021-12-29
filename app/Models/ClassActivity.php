<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivity extends Model
{
    use HasFactory;
    protected $table = 'class_activities';

    protected $fillable = [    
    	'name',        
        'criteria_id',
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')   
                ->orWhere('criteria_id', 'like', '%'.$search.'%')              
                ->orWhere('created_at', 'like', '%'.$search.'%');
    }

}
