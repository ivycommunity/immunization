<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of all the doctors.
     */
    public function index()
    {
        $doctors = Doctor::with('user')->get();

        return response()->json([
            'doctors' => $doctors,
        ]);
    }

    /**
     * Store a newly created doctor.
     */
    public function store(Request $request)
    {
        $user = auth()->guard()->user();

        if (!$user || !in_array($user->role, ['Admin', 'Receptionist'])) {
            return [
                'message' => 'Unauthorized',
            ];
        }

        $fields = $request->validate([
            'user_id' => [
            'required',
            'integer',
            'unique:doctors,user_id',
            function ($attribute, $value, $fail) {
                $user = User::find($value);
                if (!$user || $user->role !== 'Doctor') {
                $fail('The selected user must have a Doctor role.');
                }
            },
            ],
            'specialization' => 'required|string',
            'availability' => 'required|array',
            'license_number' => 'required|string',
            'work_phone_number' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        $doctor = Doctor::create([
            'user_id' => $fields['user_id'],
            'specialization' => $fields['specialization'],
            'availability'=> $fields['availability'],
            'license_number' => $fields['license_number'],
            'work_phone_number' => $fields['work_phone_number'],
            'bio' => $fields['bio'],
        ]);

        return [
            'message'=> 'Doctor record created successfully',
            'doctor' => $doctor,
        ];
        
    }

    /**
     * Display a specific doctor.
     */
    public function show($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);
    
        return response()->json([
            'doctor' => $doctor,
        ]);
    }

    /**
     * Update a doctor's record.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->guard()->user();
        $doctor = Doctor::where('id', $id)->first();
        
        if (!$doctor) {
            return response()->json([
                'message' => 'Doctor record not found',
            ], 404);
        }
        
        // Check authorization based on user role
        if ($user->role == 'Admin') {
            // Admin can update any doctor - proceed to validation and update
        }
        // Doctors can only update their own profile
        else if ($user->role == 'Doctor') {
            // Get the doctor record associated with this user
            $userDoctor = Doctor::where('user_id', $user->id)->first();
            
            if (!$userDoctor) {
                return response()->json([
                    'message' => 'Doctor profile not found for this user',
                ], 404);
            }
            
            if ($userDoctor->id != $doctor->id) {
                return response()->json([
                    'message' => 'Unauthorized to update another doctor\'s profile',
                ], 403);
            }
        }
        // Everyone else is unauthorized
        else {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        
        // Validate request data
        $validated = $request->validate([
            'specialization' => 'sometimes|string',
            'availability' => 'sometimes|array',
            'license_number' => 'sometimes|string',
            'work_phone_number' => 'sometimes|string',
            'bio' => 'sometimes|string',
        ]);
        
        // Update the doctor record
        $doctor->update($validated);
        
        // Return success response
        return response()->json([
            'message' => 'Doctor record updated successfully',
            'doctor' => $doctor,
        ]);
    }


    /**
     * Remove a doctor record.
     */
    public function destroy(Doctor $doctor)
    {
        $user = auth()->guard()->user();

        // Only admins can delete doctors
        if ($user->role !== 'Admin') {
            return response()->json([
                'message'=> 'Unauthorized'
            ]);
        }

        $doctor->delete();

        return response()->json([
            'message' => 'Doctor record deleted successfully',
        ]);
    }
}
