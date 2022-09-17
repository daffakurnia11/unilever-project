<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorMotor extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_id', 'temperature', 'ambient', 'x_axis', 'y_axis', 'z_axis', 'volt', 'ampere', 'power'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
