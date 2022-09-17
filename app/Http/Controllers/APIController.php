<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Sensor;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function show(Sensor $sensor)
    {
        $data = Sensor::where('plant_name', $sensor->plant_name)->get();

        if (!$data) {
            return ApiFormatter::createApi(400, 'Failed fetching data');
        }
        $count = $data->count();
        return ApiFormatter::createApi(200, 'Success fetching data', $count, $data);
    }

    public function setpoint(Sensor $sensor)
    {
        $data = Sensor::where('plant_name', $sensor->plant_name)->with('set_point')->get();

        if (!$data) {
            return ApiFormatter::createApi(400, 'Failed fetching data');
        }
        $count = $data->count();
        return ApiFormatter::createApi(200, 'Success fetching data', $count, $data);
    }
}
