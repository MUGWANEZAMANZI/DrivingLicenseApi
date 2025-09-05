<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterDriverController;
use App\Http\Controllers\PenaltyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register-drivers', [RegisterDriverController::class, 'register']);

Route::post('/print-license', [RegisterDriverController::class, 'printLicense']);

Route::post('/verify-license', [RegisterDriverController::class, 'verifyLicense']);

Route::post('/print-card', [RegisterDriverController::class, 'printCard']);

Route::get('/driver-search', [RegisterDriverController::class, 'driverSearch']);
Route::get('/driver-by-card/{cardNumber}', [RegisterDriverController::class, 'driverByCard']);
Route::get('/driver-by-qr/{qrData}', [RegisterDriverController::class, 'driverByQr']);

Route::post('/save-card-svg', [RegisterDriverController::class, 'saveCardSvg']);
Route::post('/save-card-tag', [RegisterDriverController::class, 'saveCardTag']);

Route::post('/add-penalty', [PenaltyController::class, 'addPenalty']);

Route::get('/license/{licenseNumber}/penalties', [PenaltyController::class, 'getPenaltiesByLicense']);