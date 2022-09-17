<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_name', 'plant_type', 'sensor_type'
    ];

    public function getRouteKeyName()
    {
        return 'plant_name';
    }

    public function sensor_motor()
    {
        return $this->hasMany(SensorMotor::class);
    }

    public function sensor_panel()
    {
        return $this->hasMany(SensorPanel::class);
    }

    public function set_point()
    {
        return $this->hasOne(SensorSetPoint::class);
    }
}
