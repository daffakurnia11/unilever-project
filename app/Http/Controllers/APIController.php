<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Sensor;
use App\Models\SensorMotor;
use App\Models\SensorPanel;
use App\Models\SensorSetPoint;
use Carbon\Carbon;
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

        if ($sensor->plant_type == 'Panel') {
            $count = SensorPanel::create($validated)->count();
        } elseif ($sensor->plant_type == 'Motor') {
            $count = SensorMotor::create($validated)->count();
        }
        return ApiFormatter::createApi(201, 'Data stored', $count, $validated);
    }

    public function latest()
    {
        $data = Sensor::with(['sensor_panel' => function ($panel) {
            $panel->latest()->first();
        }])->with(['sensor_motor' => function ($motor) {
            $motor->latest()->first();
        }])->with('set_point')->get();

        if (!$data) {
            return ApiFormatter::createApi(400, 'Failed fetching data');
        }
        return ApiFormatter::createApi(200, 'Success fetching data', 1, $data);
    }

    public function data(Sensor $sensor, Request $request)
    {
        // Filter by Panel Sensor
        if ($sensor->plant_type == 'Panel') {
            if (isset($request->filter) && isset($request->by)) {
                // Filter by minutes
                if ($request->by == 'minutes') {
                    $latest = SensorPanel::latest()->first()['created_at'];
                    $data_sensor = SensorPanel::where('sensor_id', $sensor->id)->where('created_at', '>=', Carbon::create($latest)->subMinutes($request->filter))->get();
                    $sensor['sensor_panel'] = $data_sensor;
                    // Filter by hours
                } elseif ($request->by == 'hours') {
                    $latest = SensorPanel::latest()->first()['created_at'];
                    $data_sensor = SensorPanel::where('sensor_id', $sensor->id)->where('created_at', '>=', Carbon::create($latest)->subHours($request->filter))->get();
                    $sensor['sensor_panel'] = $data_sensor;
                }
                // All datas
            } else {
                $data_sensor = SensorPanel::where('sensor_id', $sensor->id)->get();
                $sensor['sensor_panel'] = $data_sensor;
            }
            // Filter by Motor Sensor
        } elseif ($sensor->plant_type == 'Motor') {
            if (isset($request->filter) && isset($request->by)) {
                // Filter by minutes
                if ($request->by == 'minutes') {
                    $latest = SensorMotor::latest()->first()['created_at'];
                    $data_sensor = SensorMotor::where('sensor_id', $sensor->id)->where('created_at', '>=', Carbon::create($latest)->subMinutes($request->filter))->get();
                    $sensor['sensor_motor'] = $data_sensor;
                    // Filter by hours
                } elseif ($request->by == 'hours') {
                    $latest = SensorMotor::latest()->first()['created_at'];
                    $data_sensor = SensorMotor::where('sensor_id', $sensor->id)->where('created_at', '>=', Carbon::create($latest)->subHours($request->filter))->get();
                    $sensor['sensor_motor'] = $data_sensor;
                }
                // All datas
            } else {
                $data_sensor = SensorMotor::where('sensor_id', $sensor->id)->get();
                $sensor['sensor_motor'] = $data_sensor;
            }
        }

        $data = $sensor;
        $count = $data_sensor->count();

        if (!$data) {
            return ApiFormatter::createApi(400, 'Failed fetching data');
        }
        return ApiFormatter::createApi(200, 'Success fetching data', $count, $data);
    }

    public function update(Sensor $sensor, Request $request)
    {
        $setPoint = SensorSetPoint::firstWhere('sensor_id', $sensor->id);
        if ($sensor->plant_type == 'Panel') {
            $validator = Validator::make($request->all(), [
                'warning1'  => 'required',
                'warning2'  => 'required',
                'warning3'  => 'required',
                'danger1'   => 'required',
                'danger2'   => 'required',
                'danger3'   => 'required',
            ]);
        } elseif ($sensor->plant_type == 'Motor') {
            $validator = Validator::make($request->all(), [
                'warning2'  => 'required',
                'warning3'  => 'required',
                'danger2'   => 'required',
                'danger3'   => 'required',
            ]);
        }

        if ($validator->fails()) {
            return ApiFormatter::createApi(400, 'Bad Request', $validator->errors()->count(), $validator->errors());
        }

        $validated = $validator->validated();

        $setPoint->update($validated);
        $count = $setPoint->count();

        return ApiFormatter::createApi(201, 'Data stored', $count, $setPoint);
    }
}
