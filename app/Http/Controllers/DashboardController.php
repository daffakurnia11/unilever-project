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
}
