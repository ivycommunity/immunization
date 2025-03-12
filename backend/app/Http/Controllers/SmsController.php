<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SmsController extends Controller
{
    /**
     * Summary of sendAppointmentReminders
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function sendAppointmentReminders() {
        if (!env("TWILIO_SID") || !env("TWILIO_TOKEN") || !env("TWILIO_PHONE")) {
            return response()->json([
                "error" => "Twilio credentials not configured."
            ], 500);
        }
    
        $twilio = new Client(env("TWILIO_SID"), env("TWILIO_TOKEN"));
        
        $today = Carbon::now()->format('Y-m-d');
        
        // Fetch upcoming appointments within 5 days
        $appointments = Appointment::where('appointment_date', '>=', Carbon::now())
            ->where('appointment_date', '<=', Carbon::now()->addDays(5))
            ->where('status', 'Scheduled') 
            ->get();
        
        if ($appointments->isEmpty()) {
            return response()->json([
                "message" => "No upcoming appointments within the next 5 days."
            ], 200);
        }
        
        $remindersSent = [];
        $errors = [];
        
        DB::beginTransaction();
        
        try {
            foreach ($appointments as $appointment) {
                $daysUntilAppointment = ceil(Carbon::now()->floatDiffInDays(Carbon::parse($appointment->appointment_date)));
                
                $lastReminderDate = Carbon::parse($appointment->updated_at)->format('Y-m-d');
                if ($lastReminderDate == $today && $appointment->reminder_sent) {
                    continue;
                }
                
                $shouldSendReminder = in_array($daysUntilAppointment, [5, 3, 1, 0]);
                
                if (!$shouldSendReminder) {
                    continue;
                }
    
                $guardian = User::find($appointment->guardian_id);
                
                if (!$guardian || !$guardian->phone_number) {
                    continue; 
                }
                
                $guardianFullName = $guardian->first_name . " " . $guardian->last_name;
                
                if ($daysUntilAppointment == 0) {
                    $timeContext = "today";
                } elseif ($daysUntilAppointment == 1) {
                    $timeContext = "tomorrow";
                } else {
                    $timeContext = "in $daysUntilAppointment days";
                }
                
                $messageBody = "Hello {$guardianFullName}, reminder: Your child's vaccination appointment is $timeContext on " .
                    Carbon::parse($appointment->appointment_date)->format('d M Y, h:i A') .
                    ". Please visit the hospital on time.";
                
                try {
                    $message = $twilio->messages->create(
                        $guardian->phone_number,
                        [
                            "body" => $messageBody,
                            "from" => env("TWILIO_PHONE")
                        ]
                    );
                    
                    
                    $appointment->reminder_sent = true;
                    $appointment->reminder_count = $appointment->reminder_count + 1;
                    $appointment->save();
                    
                    $remindersSent[] = [
                        "appointment_id" => $appointment->id,
                        "guardian_id" => $guardian->id,
                        "days_until_appointment" => $daysUntilAppointment,
                        "reminder_count" => $appointment->reminder_count
                    ];
                    
                } catch (\Exception $e) {
                    $errors[] = [
                        "appointment_id" => $appointment->id,
                        "guardian_id" => $guardian->id,
                        "error" => $e->getMessage()
                    ];
                }
            }
            
            DB::commit();
            
            return response()->json([
                "message" => "Daily reminder process completed.",
                "date" => $today,
                "reminders_sent" => count($remindersSent),
                "reminders_detail" => $remindersSent,
                "errors" => count($errors) > 0 ? $errors : null
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                "message" => "Failed to process reminders",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
