<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionSubject extends Model
{
    use HasFactory;
    protected $table = 'section_subject';

    protected $fillable = [    
        'section_id',
        'subject_id',        
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('section_id', 'like', '%'.$search.'%')
                ->orWhere('subject_id', 'like', '%'.$search.'%')
                ->orWhere('created_at', 'like', '%'.$search.'%');                
    }
}
