<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $id = \App\Models\Sensor::create([
            'plant_name'    => 'Panel1',
            'plant_type'    => 'Panel',
            'sensor_type'   => 'bmp280',
        ])->id;
        \App\Models\SensorSetPoint::create([
            'sensor_id'     => $id,
            'warning1'      => 30,
            'danger1'       => 33,
            'warning2'      => 30,
            'danger2'       => 33,
            'warning3'      => 30,
            'danger3'       => 33,
        ]);

        $id = \App\Models\Sensor::create([
            'plant_name'    => 'Motor1',
            'plant_type'    => 'Motor',
            'sensor_type'   => 'adxl, mlx, pzem',
        ])->id;
        \App\Models\SensorSetPoint::create([
            'sensor_id'     => $id,
            'warning2'      => 30,
            'danger2'       => 33,
            'warning3'      => 5,
            'danger3'       => 7,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
