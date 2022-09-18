<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Sensor;
use App\Models\SensorMotor;
use App\Models\SensorPanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Sensor $sensor, Request $request)
    {
        if ($sensor->plant_type == 'Panel') {
            $validator = Validator::make($request->all(), [
                'temperature1'  => 'required',
                'pressure1'     => 'required',
                'temperature2'  => 'required',
                'pressure2'     => 'required',
                'temperature3'  => 'required',
                'pressure3'     => 'required',
            ]);
        } elseif ($sensor->plant_type == 'Motor') {
            $validator = Validator::make($request->all(), [
                'temperature'   => 'required',
                'ambient'       => 'required',
                'x_axis'        => 'required',
                'y_axis'        => 'required',
                'z_axis'        => 'required',
                'volt'          => 'required',
                'ampere'        => 'required',
                'power'         => 'required',
            ]);
        }

        if ($validator->fails()) {
            return ApiFormatter::createApi(400, 'Bad Request', $validator->errors()->count(), $validator->errors());
        }

        $validated = $validator->validated();
        $validated['sensor_id'] = $sensor->id;

        $count = SensorPanel::create($validated)->count();
        return ApiFormatter::createApi(201, 'Data stored', $count, $validated);
    }

    public function data(Sensor $sensor)
    {
        if ($sensor->plant_type == 'Panel') {
            $data_sensor = SensorPanel::where('sensor_id', $sensor->id)->get();
            $sensor['sensor_panel'] = $data_sensor;
        } elseif ($sensor->plant_type == 'Motor') {
            $data_sensor = SensorMotor::where('sensor_id', $sensor->id)->get();
            $sensor['sensor_motor'] = $data_sensor;
        }

        $data = $sensor;
        $count = $data_sensor->count();

        if (!$data) {
            return ApiFormatter::createApi(400, 'Failed fetching data');
        }
        return ApiFormatter::createApi(200, 'Success fetching data', $count, $data);
    }
}
