<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/{sensor}', [APIController::class, 'show']);
Route::get('/{sensor}/setpoint', [APIController::class, 'setpoint']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
