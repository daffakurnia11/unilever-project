<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function auth()
    {
        $url = env('APP_ENV') == 'local' ? env('API_DEVELOP') : env('API_PRODUCTION');
        return view('auth', [
            'sidebars'  => Sensor::all(),
            'api_url'   => $url
        ]);
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'username'  => 'required',
            'password'  => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/');
        }

        return back()->with('message', 'Login Failed');
    }

    public function index()
    {
        $url = env('APP_ENV') == 'local' ? env('API_DEVELOP') : env('API_PRODUCTION');
        return view('index', [
            'sidebars'  => Sensor::all(),
            'api_url'   => $url
        ]);
    }

    public function monitoring(Sensor $sensor, Request $request)
    {
        $url = env('APP_ENV') == 'local' ? env('API_DEVELOP') : env('API_PRODUCTION');
        if ($sensor->plant_type == 'Panel') {
            return view('monitoring.panel', [
                'sidebars'  => Sensor::all(),
                'sensor'    => $sensor,
                'request'   => $request,
                'api_url'   => $url
            ]);
        } elseif ($sensor->plant_type == 'Motor') {
            return view('monitoring.motor', [
                'sidebars'  => Sensor::all(),
                'sensor'    => $sensor,
                'request'   => $request,
                'api_url'   => $url
            ]);
        }
    }

    public function setpoint(Sensor $sensor)
    {
        $url = env('APP_ENV') == 'local' ? env('API_DEVELOP') : env('API_PRODUCTION');
        $request = file_get_contents($url . $sensor->plant_name . '/setpoint');
        $response = json_decode($request);

        if ($sensor->plant_type == 'Panel') {
            return view('setpoint.panel', [
                'sidebars'  => Sensor::all(),
                'sensor'    => $sensor,
                'setpoints' => $response->data[0]->set_point,
                'api_url'   => $url
            ]);
        } elseif ($sensor->plant_type == 'Motor') {
            return view('setpoint.motor', [
                'sidebars'  => Sensor::all(),
                'sensor'    => $sensor,
                'setpoints' => $response->data[0]->set_point,
                'api_url'   => $url
            ]);
        }
    }
}
