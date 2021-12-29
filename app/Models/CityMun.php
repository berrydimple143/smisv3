<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityMun extends Model
{
    protected $table = 'citymuns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'REGION_C',
        'PROVINCE_C',
        'CITYMUN_C',
        'CITYMUN',
        'LEVEL', 
        'CLASS', 
        'INCOME_CLASS'
    ];
}
