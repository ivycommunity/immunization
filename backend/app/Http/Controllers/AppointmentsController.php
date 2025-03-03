<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    /**
     * Display all the appointments.
     */
    public function index()
    {
        $user = auth()->guard()->user();

        // Only Admin and Receptionist can view all appointments
        if ($user->role == 'Admin' || $user->role == 'Receptionist'){
            $appointments = Appointment::with('baby','doctor','vaccine')->get();

            return response()->json([
                'appointments'=> $appointments
            ]);
        }

        // Doctors can only view their own appointments
        else if ($user->role == 'Doctor'){
            // Get the doctor record associated with this user
            $doctor = Doctor::where('user_id', $user->id)->first();

            if (! $doctor) {
                return response()->json([
                    'message'=> 'Doctor profile not found'
                ]);
            }

            $appointments = Appointment::with(['baby','doctor','vaccine'])
                ->where('doctor_id', $doctor->id)
                ->get();

            return response()->json([
                'appointments'=> $appointments
            ]);
        }
        else {
            return response()->json([
                'message'=> 'Unauthorized'
            ]);
        }

        
    }

    /**
     * Store a new appointment record.
     */
    public function store(Request $request)
    {
        $user = auth()->guard()->user();

        //Only Admin and Receptionist can create appointments
        if (!$user || !in_array($user->role, ['Admin','Receptionist'])) {
            return response()->json([
                'message'=> 'Unauthorized'
            ]);
        }

        $request->validate([
            'baby_id' => 'required|integer',
            'guardian_id' => 'required|integer',
            'vaccine_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'status' => 'required|string',
            'reminder_sent' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create($request->all());

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => $appointment,
        ]);
    }

    /**
     * Display a specific appointment record.
     */
    public function show($id)
    {
        $user = auth()->guard()->user();
        $appointment = Appointment::with(['baby','doctor','vaccine'])->findOrFail($id);

        // Admin and Receptionist can view any appointment
        if ($user->role == 'Admin' || $user->role == 'Receptionist') {
            return response()->json([
                'appointment' => $appointment,
            ]);
        }
        // Doctors can only view their own appointments
        else if ($user->role == 'Doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();
            
            if (!$doctor) {
                return response()->json([
                    'message' => 'Doctor profile not found for this user'
                ], 404);
            }

            if ($appointment->doctor_id == $doctor->id) {
                return response()->json([
                    'appointment' => $appointment,
                ]);
            } else {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 403);
            }
        }
        else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
    }

    /**
     * Update the specified appointment  record.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->guard()->user();
        $appointment = Appointment::findOrFail($id);

        // Check authorization based on role
        if ($user->role == 'Admin'|| $user->role == 'Receptionist') {

            $request->validate([
                'vaccine_id' => 'integer',
                'doctor_id' => 'integer',
                'appointment_date' => 'date',
                'status' => 'in:Scheduled,Completed,Missed,Cancelled',
                'reminder_sent' => 'boolean',
                'notes' => 'nullable|string',
            ]);

            $appointment->update($request->all());

            return response()->json([
                'message' => 'Appointment updated successfully',
                'appointment' => $appointment,
            ]);
        }
        else if ($user->role == 'Doctor') {
            // Get the doctor record associated with this user
            $doctor = Doctor::where('user_id', $user->id)->first();

            if (!$doctor) {
                return response()->json([
                    'message' => 'Doctor profile not found'
                ], 404);
            }

            // Doctors can only update their own appointments
            if ($appointment->doctor_id == $doctor->id) {
                $request->validate([
                    'status' => 'in:Scheduled,Completed,Missed,Cancelled',
                    'notes' => 'nullable|string',
                ]);

            //Doctors to update specific fields
            $appointment->update($request->only(['status', 'notes']));

            return response()->json([
                'message' => 'Appointment updated successfully',
                'appointment' => $appointment,
            ]);
            } else {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 403);
            }
        }
        else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
    }

    /**
     * Remove a doctor record.
     */
    public function destroy($id)
    {
        $user = auth()->guard()->user();

        if ($user->role !== 'Admin') {
            return response()->json([
                'message'=> 'Unauthorized'
            ]);
        }

        $appointment = Appointment::findOrFail($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found',
            ]);
        }

        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully',
        ]);
    }
}
