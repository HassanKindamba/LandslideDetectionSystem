<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "api" middleware group.
|
*/

// Test route (optional)
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!'
    ]);
});

// Sensor Data API
Route::post('/sensor-data', [SensorDataController::class, 'store']);

// Authenticated user (optional - default Laravel)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/live-api', [SensorDataController::class, 'liveApi']);