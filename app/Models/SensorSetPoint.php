<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorSetPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_id', 'set_point1', 'set_point2', 'set_point3'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
