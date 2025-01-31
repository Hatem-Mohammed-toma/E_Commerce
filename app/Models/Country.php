<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;


    protected $fillable = [
        'country_name',
        'city_name',
        'event_name',
        'desc_name',
        'date',
        'latitude',
        'longitude',
    ];

}
