<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Baby;

class SmsController extends Controller
{
    /**
     * Send appointment reminders with enhanced reminder logic
     */
    public function sendAppointmentReminders() {
        if (!env("TWILIO_SID") || !env("TWILIO_TOKEN") || !env("TWILIO_PHONE")) {
            return response()->json([
                "error" => "Twilio credentials not configured."
            ], 500);
        }
    
        $twilio = new Client(env("TWILIO_SID"), env("TWILIO_TOKEN"));
        
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        
        $appointments = Appointment::where('appointment_date', '>=', $now)
            ->where('status', 'Scheduled')
            ->get();
        
        if ($appointments->isEmpty()) {
            return response()->json([
                "message" => "No upcoming appointments that need reminders."
            ], 200);
        }
        
        $remindersSent = [];
        $errors = [];
        
        DB::beginTransaction();
        
        try {
            foreach ($appointments as $appointment) {
                $appointmentDate = Carbon::parse($appointment->appointment_date);
                $daysUntilAppointment = ceil($now->floatDiffInDays($appointmentDate));
                
                // Skip if reminder conditions are not met
                if ($daysUntilAppointment > 7 || $daysUntilAppointment < 0) {
                    continue;
                }
                
                $guardian = User::find($appointment->guardian_id);
                
                if (!$guardian || !$guardian->phone_number) {
                    continue; 
                }
                
                $guardianFullName = $guardian->first_name . " " . $guardian->last_name;
                
                if ($daysUntilAppointment == 0) {
                    // Morning of appointment reminder
                    $messageBody = "Hello {$guardianFullName}, this is a reminder that your child's vaccination appointment is TODAY on " .
                        $appointmentDate->format('d M Y, h:i A') .
                        ". Please visit the hospital on time.";
                    
                    // Only send if not already sent today
                    if (!$appointment->morning_reminder_sent) {
                        $sendReminder = true;
                        $reminderType = 'morning_reminder_sent';
                    } else {
                        $sendReminder = false;
                    }
                } else {
                    // 7-day to 1-day before appointment reminders
                    $messageBody = "Hello {$guardianFullName}, reminder: Your child's vaccination appointment is " . 
                        ($daysUntilAppointment == 1 ? "tomorrow" : "in $daysUntilAppointment days") . 
                        " on " . $appointmentDate->format('d M Y, h:i A') .
                        ". Please visit the hospital on time.";
                    
                    // Only send if not already sent for this day
                    $sendReminder = true;
                    $reminderType = 'reminder_sent';
                }
                
                if ($sendReminder) {
                    try {
                        $message = $twilio->messages->create(
                            $guardian->phone_number,
                            [
                                "body" => $messageBody,
                                "from" => env("TWILIO_PHONE")
                            ]
                        );
                        
                        // Update reminder tracking
                        $appointment->$reminderType = true;
                        $appointment->reminder_count = $appointment->reminder_count + 1;
                        $appointment->save();
                        
                        $remindersSent[] = [
                            "appointment_id" => $appointment->id,
                            "guardian_id" => $guardian->id,
                            "days_until_appointment" => $daysUntilAppointment,
                            "reminder_type" => $reminderType,
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

    /**
     * Send patient ID notification to the guardian
     */
   public function sendPatientIdNotification($babyId)
   {
       if (!env("TWILIO_SID") || !env("TWILIO_TOKEN") || !env("TWILIO_PHONE")) {
           return response()->json([
               "error" => "Twilio credentials not configured."
           ], 500);
       }
   
       try {
           $baby = Baby::find($babyId);
           
           if (!$baby) {
               return response()->json([
                   "error" => "Baby record not found."
               ], 404);
           }
           
           $guardian = User::find($baby->guardian_id);
           
           if (!$guardian || !$guardian->phone_number) {
               return response()->json([
                   "error" => "Guardian not found or phone number not available."
               ], 404);
           }
           
           $twilio = new Client(env("TWILIO_SID"), env("TWILIO_TOKEN"));
           
           $guardianFullName = $guardian->first_name . " " . $guardian->last_name;
           $messageBody = "Hello {$guardianFullName}, your child's record has been created successfully. " .
                          "The patient ID is: {$baby->patient_id}. Please keep this ID for future reference.";
           
           $message = $twilio->messages->create(
               $guardian->phone_number,
               [
                   "body" => $messageBody,
                   "from" => env("TWILIO_PHONE")
               ]
           );
           
           return response()->json([
               "message" => "Patient ID notification sent successfully.",
               "baby_id" => $baby->id,
               "patient_id" => $baby->patient_id,
               "guardian_id" => $guardian->id
           ], 200);
           
       } catch (\Exception $e) {
           return response()->json([
               "message" => "Failed to send patient ID notification",
               "error" => $e->getMessage()
           ], 500);
       }
   }
}