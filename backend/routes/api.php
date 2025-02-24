<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuardianController;
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