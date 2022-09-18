<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('index', [
            'sidebars'  => Sensor::all()
        ]);
    }

    public function monitoring(Sensor $sensor)
    {
        if ($sensor->plant_type == 'Panel') {
            return view('monitoring.panel', [
                'sidebars'  => Sensor::all(),
                'sensor'    => $sensor
            ]);
        } elseif ($sensor->plant_type == 'Motor') {
            return view('monitoring.motor', [
                'sidebars'  => Sensor::all(),
                'sensor'    => $sensor
            ]);
        }
    }

    public function setpoint(Sensor $sensor)
    {
        $request = file_get_contents('http://192.168.55.102/unilever-project/public/api/' . $sensor->plant_name . '/setpoint');
        $response = json_decode($request);

        if ($sensor->plant_type == 'Panel') {
            return view('setpoint.panel', [
                'sidebars'  => Sensor::all(),
                'sensor'    => $sensor,
                'setpoints' => $response->data[0]->set_point
            ]);
        } elseif ($sensor->plant_type == 'Motor') {
            return view('setpoint.motor', [
                'sidebars'  => Sensor::all(),
                'sensor'    => $sensor,
                'setpoints' => $response->data[0]->set_point
            ]);
        }
    }
}
