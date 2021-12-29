<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $table = 'barangays';

    protected $fillable = [
        'Code',
        'Name',
        'Level',
        'OldName'
    ];
}
