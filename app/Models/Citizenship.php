<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizenship extends Model
{
    protected $table = 'citizenship';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'description'
    ];
}
