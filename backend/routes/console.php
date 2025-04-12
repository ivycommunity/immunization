<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\BabyController;
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

Schedule::call(function () {
    $affected = Appointment::where('status', 'Missed')
        ->where('missed_notification_sent', true)
        ->update(['missed_notification_sent' => false]);
})->dailyAt('00:01');

Schedule::call(function () {
    $babyController = new BabyController();
    $babyController->updateImmunizationStatus();
})->everyTwoHours();

// New scheduler task for missed appointment notifications
Schedule::call(function () {
    $smsController = new SmsController();
    $smsController->sendMissedAppointmentNotifications();
})->hourly()->between('8:00', '20:00');