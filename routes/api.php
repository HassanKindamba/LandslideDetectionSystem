<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Test route (optional)
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!'
    ]);
});

// 1. ESP32 POST Request -> URL: http://192.168.43.11:8000/api/sensor-data
Route::post('/sensor-data', [SensorDataController::class, 'store']);

// 2. Dashboard Live Fetch -> URL: http://127.0.0.1:8000/api/live-api
Route::get('/live-api', [SensorDataController::class, 'liveApi']);

// Authenticated user (optional)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});