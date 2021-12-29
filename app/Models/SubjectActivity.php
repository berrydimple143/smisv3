<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectActivity extends Model
{
    use HasFactory;
    protected $table = 'subject_activity';

    protected $fillable = [
        'subject_id',
        'class_activity_id',
        'section_id',
    ];

    public static function search($search) {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('subject_id', 'like', '%'.$search.'%')
                ->orWhere('section_id', 'like', '%'.$search.'%')
                ->orWhere('class_activity_id', 'like', '%'.$search.'%')
                ->orWhere('created_at', 'like', '%'.$search.'%');                
    }    

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id'); 
    }
}
