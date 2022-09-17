<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorPanel extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_id', 'temperature1', 'pressure1', 'temperature2', 'pressure2', 'temperature3', 'pressure3'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
