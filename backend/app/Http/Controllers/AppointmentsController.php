<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    /**
     * Display all the appointments.
     */
    public function index()
    {
        $user = auth()->guard()->user();

        if (in_array($user->role, ['admin', 'nurse', 'doctor'])) {
            $appointments = Appointment::with([
                'baby', 
                'guardian',
                'doctor', 
                'vaccine'])
                ->select('id', 'baby_id','guardian_id', 'doctor_id', 'vaccine_id', 'appointment_date', 'status','reminder_sent' ,'notes')
                ->get();
        } elseif ($user->role == 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();

            if (!$doctor) {
                return response()->json(['message' => 'Doctor profile not found'], 404);
            }

            $appointments = Appointment::with([
                'baby', 
                'guardian',
                'doctor', 
                'vaccine'
                ])
                ->where('doctor_id', $doctor->id)
                ->select('id', 'baby_id', 'guardian_id','doctor_id', 'vaccine_id', 'appointment_date', 'status', 'reminder_sent' ,'notes') 
                ->get();
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

        //Only Admin and Receptionist can create appointments
        if (!$user || !in_array($user->role, ['admin','nurse','doctor'])) {
            return response()->json([
                'message'=> 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'baby_id' => 'required|exists:babies,id',
            'guardian_id' => 'required|exists:users,id',
            'vaccine_id' => 'required|exists:vaccines,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'status' => 'required|string|in:Scheduled,Completed,Missed,Cancelled',
            'reminder_sent' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create($request->all());

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => new AppointmentResource($appointment->load(['baby', 'guardian','doctor', 'vaccine'])),
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
            'vaccine'])
            ->find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        if (in_array($user->role, ['admin', 'nurse', 'doctor'])) {
            return new AppointmentResource($appointment);
        }

        if ($user->role == 'doctor' && optional($appointment->doctor)->user_id == $user->id) {
            return new AppointmentResource($appointment);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
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
                'appointment_date' => 'date',
                'status' => 'in:Scheduled,Completed,Missed,Cancelled',
                'reminder_sent' => 'boolean',
                'notes' => 'nullable|string',
            ]);

            $appointment->update($request->only([
                'baby_id','guardian_id','vaccine_id', 'doctor_id', 'appointment_date', 'status', 'reminder_sent', 'notes'
            ]));
        } elseif ($user->role == 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();

            if (!$doctor || $appointment->doctor_id != $doctor->id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $request->validate([
                'status' => 'in:Scheduled,Completed,Missed,Cancelled',
                'notes' => 'nullable|string',
            ]);

            $appointment->update($request->only(['status', 'notes']));
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => new AppointmentResource($appointment->load(['baby','guardian', 'doctor', 'vaccine'])),
        ]);
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