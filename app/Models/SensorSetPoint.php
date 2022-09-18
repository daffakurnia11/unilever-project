<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorSetPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_id', 'warning1', 'warning2', 'warning3', 'danger1', 'danger2', 'danger3'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
