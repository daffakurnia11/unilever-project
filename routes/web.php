<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth', [DashboardController::class, 'auth']);
Route::post('/auth', [DashboardController::class, 'authentication']);
Route::get('/', [DashboardController::class, 'index']);

Route::get('/{sensor}/monitoring', [DashboardController::class, 'monitoring']);
Route::get('/{sensor}/setpoint', [DashboardController::class, 'setpoint']);
