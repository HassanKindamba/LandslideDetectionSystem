<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $fillable = [
        'soil_moisture',
        'vibration',
        'tilt',
        'risk_level'
    ];
}
