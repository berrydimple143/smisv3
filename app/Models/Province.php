<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    protected $fillable = [
        'REGION_C',
        'PROVINCE_C',
        'PROVINCE'
    ];
}
