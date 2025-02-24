<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\VaccineController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authorization routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

// Guardian routes
Route::get('/guardians', [GuardianController::class,'getGuardians'])->middleware('auth:sanctum');
Route::get('/guardians/{id}', [GuardianController::class,'getGuardian'])->middleware('auth:sanctum');
Route::put('/guardians/{id}', [GuardianController::class,'updateGuardian'])->middleware('auth:sanctum');
Route::delete('/guardians/{id}', [GuardianController::class,'deleteGuardian'])->middleware('auth:sanctum');

// Baby routes
Route::get('/babies', [BabyController::class,'index'])->middleware('auth:sanctum');
Route::get('/babies/{id}', [BabyController::class,'show'])->middleware('auth:sanctum');
Route::post('/babies', [BabyController::class,'store'])->middleware('auth:sanctum');
Route::put('/babies/{id}', [BabyController::class,'update'])->middleware('auth:sanctum');
Route::delete('/babies/{id}', [BabyController::class,'destroy'])->middleware('auth:sanctum');

// Vaccine routes
Route::get('/vaccines', [VaccineController::class,'index'])->middleware('auth:sanctum');
Route::get('/vaccines/{id}', [VaccineController::class,'show'])->middleware('auth:sanctum');
Route::post('/vaccines', [VaccineController::class,'store'])->middleware('auth:sanctum');
Route::put('/vaccines/{id}', [VaccineController::class,'update'])->middleware('auth:sanctum');
Route::delete('/vaccines/{id}', [VaccineController::class,'destroy'])->middleware('auth:sanctum');
