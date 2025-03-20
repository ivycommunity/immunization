<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Baby;
use App\Models\User;
use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    /**
     * Display all the appointments.
     */
    public function index(Request $request)
    {
        $user = auth()->guard()->user();
        $status = $request->query('status');

        $query = Appointment::with(['baby', 'guardian', 'doctor', 'vaccine', 'nurse']);
                
        if ($status && in_array($status, ['Scheduled', 'Completed', 'Missed', 'Cancelled'])) {
            $query->where('status', $status);
        }

        if ($user->role === 'admin') {
            $appointments = $query->get();
        } elseif ($user->role === 'nurse') {
            if ($request->query('view') === 'mine') {
                $appointments = $query->where('nurse_id', $user->id)->get();
            } else {
                $appointments = $query->get();
            }
        } elseif ($user->role === 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();
            
            if (!$doctor) {
                return response()->json(['message' => 'Doctor profile not found'], 404);
            }

            if ($request->query('view') === 'mine') {
                $appointments = $query->where('doctor_id', $doctor->id)->get();
            } else {
                $appointments = $query->get();
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return AppointmentResource::collection($appointments);
    }

    /**
     * Store a new appointment record.
     */
    public function store(Request $request)
    {
        $user = auth()->guard()->user();

        if (!$user || !in_array($user->role, ['admin','nurse','doctor'])) {
            return response()->json([
                'message'=> 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'baby_id' => 'required|exists:babies,id',
            'guardian_id' => 'required|exists:users,id',
            'vaccine_id' => 'required|exists:vaccines,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'appointment_date' => 'required',
            'status' => 'required|string|in:Scheduled,Completed,Missed,Cancelled',
            'reminder_sent' => 'required|boolean',
            'notes' => 'nullable|string',
            'nurse_id' => 'required|exists:users,id',
        ]);

        $appointmentData = $request->only([
            'baby_id', 'guardian_id', 'vaccine_id', 'appointment_date', 
            'status', 'reminder_sent', 'notes'
        ]);

        $appointmentData['doctor_id'] = null;
        $appointmentData['nurse_id'] = null;

        $appointment = Appointment::create($appointmentData);

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => new AppointmentResource($appointment->load(['baby', 'guardian','doctor', 'vaccine', 'nurse'])),
        ], 201);
    }

    /**
     * Display a specific appointment record.
     */
    public function show($id)
    {
        $user = auth()->guard()->user();
        $appointment = Appointment::with([
            'baby', 
            'guardian',
            'doctor', 
            'nurse',
            'vaccine'])
            ->find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        if (!in_array($user->role, ['admin', 'nurse', 'doctor'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified appointment record.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->guard()->user();
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        if (in_array($user->role, ['admin', 'nurse', 'doctor'])) {
            $request->validate([
                'baby_id' => 'integer|exists:babies,id',
                'guardian_id' => 'integer|exists:users,id',
                'vaccine_id' => 'integer|exists:vaccines,id',
                'doctor_id' => 'integer|exists:doctors,id',
                'nurse_id'=> 'integer|exists:users,id',
                'appointment_date' => 'date',
                'status' => 'in:Scheduled,Completed,Missed,Cancelled',
                'reminder_sent' => 'boolean',
                'notes' => 'nullable|string',
            ]);

            $appointment->update($request->only([
                'baby_id','guardian_id','vaccine_id', 'doctor_id','nurse_id', 'appointment_date', 'status', 'reminder_sent', 'notes'
            ]));
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => new AppointmentResource($appointment->load(['baby', 'guardian','doctor', 'vaccine', 'nurse'])),
        ]);
    }


    /**
     * Get vaccination history for a specific baby
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBabyVaccinationHistory($babyId)
    {
        $user = auth()->guard()->user();

        if (!$user || !in_array($user->role, ['admin', 'nurse', 'doctor'])) {
            return response()->json([
                'message'=> 'Unauthorized'
            ], 403);
        }

        $babyExists = Baby::where('id', $babyId)->exists();
        if (!$babyExists) {
            return response()->json([
                'message' => 'Baby not found'
            ], 404);
        }

        $appointments = Appointment::where('baby_id', $babyId)
                ->with(['baby', 'guardian', 'doctor', 'nurse', 'vaccine'])
                ->orderBy('appointment_date', 'desc')
                ->get();
        
        $groupedByStatus = $appointments->groupBy('status');
        
        $result = [
            'baby_id' => $babyId,
            'total_appointments' => $appointments->count(),
            'by_status' => []
        ];
        
        foreach (['Scheduled', 'Completed', 'Missed', 'Cancelled'] as $status) {
            $result['by_status'][$status] = [
                'count' => isset($groupedByStatus[$status]) ? $groupedByStatus[$status]->count() : 0,
                'appointments' => isset($groupedByStatus[$status]) ? 
                    AppointmentResource::collection($groupedByStatus[$status]) : []
            ];
        }
        
        return response()->json([
            'message' => 'Baby vaccination history retrieved successfully',
            'data' => $result
        ], 200);
    }

    /**
     * Get vaccination history by guardian ID
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVaccinationHistoryByGuardian($guardianId)
    {
        $user = auth()->guard()->user();

        if (!$user || !in_array($user->role, ['admin', 'nurse', 'doctor'])) {
            return response()->json([
                'message'=> 'Unauthorized'
            ], 403);
        }

        $guardianExists = User::where('id', $guardianId)->exists();
        if (!$guardianExists) {
            return response()->json([
                'message' => 'Guardian not found'
            ], 404);
        }

        // Get all appointments for this guardian
        $appointments = Appointment::where('guardian_id', $guardianId)
                ->with(['baby', 'guardian', 'doctor', 'nurse', 'vaccine'])
                ->orderBy('appointment_date', 'desc')
                ->get();
        
        // First group by baby
        $groupedByBaby = $appointments->groupBy('baby_id');
        $babiesData = [];
        
        foreach ($groupedByBaby as $babyId => $babyAppointments) {
            if (count($babyAppointments) > 0) {
                $baby = $babyAppointments[0]->baby;
                
                // Then group by status for each baby
                $groupedByStatus = $babyAppointments->groupBy('status');
                
                $statusData = [];
                foreach (['Scheduled', 'Completed', 'Missed', 'Cancelled'] as $status) {
                    $statusData[$status] = [
                        'count' => isset($groupedByStatus[$status]) ? $groupedByStatus[$status]->count() : 0,
                        'appointments' => isset($groupedByStatus[$status]) ? 
                            AppointmentResource::collection($groupedByStatus[$status]) : []
                    ];
                }
                
                $babyData = [
                    'baby_id' => $babyId,
                    'baby_name' => $baby->first_name . ' ' . $baby->last_name,
                    'total_appointments' => count($babyAppointments),
                    'by_status' => $statusData
                ];
                
                $babiesData[] = $babyData;
            }
        }
        
        return response()->json([
            'message' => 'Guardian\'s babies vaccination history retrieved successfully',
            'guardian_id' => $guardianId,
            'total_babies' => count($babiesData),
            'data' => $babiesData
        ], 200);
    }


    /**
     * Remove an appointment record.
     */
    public function destroy($id)
    {
        $user = auth()->guard()->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'message'=> 'Unauthorized'
            ], 403);
        }

        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found',
            ], 404);
        }

        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully',
        ]);
    }
}