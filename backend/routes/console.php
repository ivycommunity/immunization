<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SmsController;
use App\Models\Appointment;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//Command to send reminders
Artisan::command('reminders:send', function(){
    $controller = new SmsController();
    $response = $controller->sendAppointmentReminders();

    $data = $response->getData(true);

    $this->info('Reminder process completed.');
    $this->info('Reminders sent: ' . ($data['reminders_sent'] ?? 0));

    return 0;
})->purpose('Send appointment reminders');

//Command to reset reminder_sent flag
Artisan::command('reminders:reset', function () {
    $affected = Appointment::where('reminder_sent', true)
        ->update(['reminder_sent' => false]);
    
    $this->info("Reset reminder_sent flag for {$affected} appointments.");
    
    return 0;
})->purpose('Reset the reminder_sent flag for all appointments');

//Schedule commands
Artisan::command('schedule-tasks', function (Schedule $schedule) {
    $schedule->command('reminders:send')->dailyAt('11:00');
    $schedule->command('reminders:reset')->dailyAt('00:01');
})->purpose('Define scheduled tasks');