<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\Baby;
use App\Models\User;

class BabyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $babies = Baby::with('guardian:id,first_name,last_name')->get();

        return response()->json([
            'babies' => $babies
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'guardian_id' => 'required|exists:users,id',
            'gender' => 'required|string|in:Male,Female,Other',
            'immunization_status' => 'required|string|max:255',
            'last_vaccine_received' => 'nullable|string|max:255',
            'next_appointment_date' => 'nullable|date',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
        ]);

        //Generate a unique 6-digit patient ID
        $patientId = $this->generateUniquePatientId();
        $validatedData['patient_id'] = $patientId;

        $baby = Baby::create($validatedData);

        $notificationResult = $this->notifyGuardianAboutPatientId($baby);

        return response()->json([
            'baby' => $baby,
            'notification_sent' => $notificationResult['success'],
            'notification_message' => $notificationResult['message']
        ], 201);
    }

    /**
     * Generate a unique 6-digit patient ID.
     */
    private function generateUniquePatientId()
    {
        do {
            $patientId = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $exists = Baby::where('patient_id', $patientId)->exists();
        } while ($exists);
        return $patientId;
    }

    /**
     * Notify the guardian about the generated patient ID.
     */
    private function notifyGuardianAboutPatientId(Baby $baby){
        try {
            $smsController = new SmsController();
            $response = $smsController->sendPatientIdNotification($baby->id);

            $responseData = json_decode($response->getContent(), true);

            if ($response->getStatusCode() == 200) {
                return [
                    'success' => true,
                    'message' => 'Patient ID notification sent successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $responseData['error'] ?? 'Failed to send notification'
                ];
            }
        }catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Failed to send patient ID notification: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to send notification: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $baby = Baby::find($id);
        if (!$baby) {
            return response()->json(['message' => 'Baby not found'], 404);
        }
        return response()->json($baby);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $baby = Baby::find($id);
        if (!$baby) {
            return response()->json(['message' => 'Baby not found'], 404);
        }

        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'guardian_id' => 'sometimes|exists:users,id',
            'gender' => 'sometimes|string|in:Male,Female,Other',
            'immunization_status' => 'sometimes|string|max:255',
            'last_vaccine_received' => 'nullable|string|max:255',
            'next_appointment_date' => 'nullable|date',
            'date_of_birth' => 'sometimes|date',
            'nationality' => 'sometimes|string|max:255',
        ]);

        $baby->update($validatedData);
        return response()->json($baby);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $baby = Baby::find($id);
        if (!$baby) {
            return response()->json(['message' => 'Baby not found'], 404);
        }

        $baby->delete();
        return response()->json(['message' => 'Baby deleted successfully']);
    }

    public function getBabyByGuardianId($guardianId): JsonResponse
    {
        $guardian = User::with('babies')->find($guardianId);

        if (!$guardian) {
            return response()->json(['message' => 'Guardian not found'], 404);
        }

        return response()->json($guardian->babies);
    }

    /**
     * Update the immunization status of all babies.
     */
    public function updateImmunizationStatus(): JsonResponse
    {
        $babies = Baby::with(['appointments' => function ($query) {
            $query->whereIn('status', ['Completed', 'Missed'])
                  ->orderBy('appointment_date', 'desc');
        }])->get();

        foreach ($babies as $baby) {
            $latestCompletedAppointment = $baby->appointments
                ->where('status', 'Completed')
                ->first();

            $missedAppointments = $baby->appointments
                ->where('status', 'Missed');

            $status = 'Pending';

            if ($latestCompletedAppointment) {
                $status = 'Up to date';
            } elseif ($missedAppointments->count() > 0 && !$latestCompletedAppointment) {
                $status = 'Overdue';
            }

            if (
                $baby->next_appointment_date &&
                Carbon::parse($baby->next_appointment_date)->isPast() &&
                !$latestCompletedAppointment
            ) {
                $status = 'Overdue';
            }

            if ($baby->immunization_status !== $status) {
                $baby->update([
                    'immunization_status' => $status
                ]);
            }
        }

        return response()->json([
            'message' => 'Immunization statuses updated successfully'
        ]);
    }


}

