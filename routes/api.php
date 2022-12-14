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

Route::get('/all/latest', [APIController::class, 'latest']);
Route::get('/{sensor}', [APIController::class, 'show']);
Route::get('/{sensor}/setpoint', [APIController::class, 'setpoint']);
Route::get('/{sensor}/data', [APIController::class, 'data']);

Route::post('{sensor}', [APIController::class, 'store']);
Route::patch('{sensor}', [APIController::class, 'update']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
