<?php

use App\Http\Controllers\AppointmentsController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SmsController;
use App\Models\Appointment;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $smsController = new SmsController();
    $response = $smsController->sendAppointmentReminders();
})->dailyAt('10:00');

Schedule::call(function () {
    $affected = Appointment::where('reminder_sent', true)
        ->update(['reminder_sent' => false]);
})->dailyAt('00:01');

Schedule::call(function () {
    $appointmentController = new AppointmentsController();
    $appointmentController->updateMissedAppointments();
})->hourly()->between('8:00', '20:00');