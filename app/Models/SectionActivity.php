<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionActivity extends Model
{
    use HasFactory;
    protected $table = 'section_activities';

    protected $fillable = [    
        'section_id',
        'class_activity_id',        
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('section_id', 'like', '%'.$search.'%')
                ->orWhere('class_activity_id', 'like', '%'.$search.'%')
                ->orWhere('created_at', 'like', '%'.$search.'%');                
    }    

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');        
    }
    
}
