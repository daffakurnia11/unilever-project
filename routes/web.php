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

Route::get('/auth', [DashboardController::class, 'auth'])->middleware('guest')->name('login');
Route::post('/auth', [DashboardController::class, 'authentication'])->middleware('guest');

Route::post('/logout', [DashboardController::class, 'logout'])->middleware('auth');
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/{sensor}/monitoring', [DashboardController::class, 'monitoring'])->middleware('auth');
Route::get('/{sensor}/setpoint', [DashboardController::class, 'setpoint'])->middleware('auth');
