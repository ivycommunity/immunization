<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class,'register'])->middleware('auth:sanctum');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('babies', BabyController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/guardians', [GuardianController::class,'getGuardians']);
    Route::get('/guardians/{id}', [GuardianController::class,'getGuardian']);
    Route::put('/guardians/{id}', [GuardianController::class,'updateGuardian']);
    Route::delete('/guardians/{id}', [GuardianController::class,'deleteGuardian']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('doctors', DoctorController::class)->except(['create', 'edit']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('appointments', AppointmentsController::class)->except(['create', 'edit']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/vaccines', [VaccineController::class, 'getVaccines']);
    Route::post('/vaccines', [VaccineController::class, 'createVaccine']);
    Route::get('/vaccines/{id}', [VaccineController::class, 'getVaccine']);
    Route::put('/vaccines/{id}', [VaccineController::class, 'updateVaccine']);
    Route::delete('/vaccines/{id}', [VaccineController::class, 'deleteVaccine']);
});

Route::post('/send-reminders', [SmsController::class, 'sendAppointmentReminders']);