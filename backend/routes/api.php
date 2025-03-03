<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\VaccineController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authorization routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('babies', BabyController::class);
});
// Guardian routes
Route::get('/guardians', [GuardianController::class,'getGuardians'])->middleware('auth:sanctum');
Route::get('/guardians/{id}', [GuardianController::class,'getGuardian'])->middleware('auth:sanctum');
Route::put('/guardians/{id}', [GuardianController::class,'updateGuardian'])->middleware('auth:sanctum');
Route::delete('/guardians/{id}', [GuardianController::class,'deleteGuardian'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/vaccines', [VaccineController::class, 'getVaccines']);
    Route::post('/vaccines', [VaccineController::class, 'createVaccine']);
    Route::get('/vaccines/{id}', [VaccineController::class, 'getVaccine']);
    Route::put('/vaccines/{id}', [VaccineController::class, 'updateVaccine']);
    Route::delete('/vaccines/{id}', [VaccineController::class, 'deleteVaccine']);
});