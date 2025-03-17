<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\DoctorResource;

class DoctorController extends Controller
{
    /**
     * Display a listing of all the doctors.
     * 
     */
    public function index()
    {
        $doctors = Doctor::with(['user:id,first_name,last_name,email,phone_number,gender'])
        ->select('id', 'user_id', 'specialization', 'availability', 'license_number', 'work_phone_number', 'bio')
        ->get();

        return DoctorResource::collection($doctors);
    }

    /**
     * Store a newly created doctor.
     */
    public function store(Request $request)
    {
        $user = auth()->guard()->user();

        if (!$user || !in_array($user->role, ['admin', 'nurse', 'doctor'])) {
           return response()->json([
               'message'=> 'Unauthorized'
           ], 403);
        }

        $fields = $request->validate([
            'user_id' => [
            'required',
            'integer',
            'unique:doctors,user_id',
            function ($attribute, $value, $fail) {
                $user = User::find($value);
                if (!$user || $user->role !== 'doctor') {
                $fail('The selected user must have a Doctor role.');
                }
            },
            ],
            'specialization' => 'required|string',
            'license_number' => 'required|string',
            'work_phone_number' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        $doctor = Doctor::create($fields);

        return response()->json([
            'message' => 'Doctor record created successfully',
            'doctor' => new DoctorResource($doctor->load('user')),
        ], 201);        
        
    }

    /**
     * Display a specific doctor.
     */
    public function show($id)
    {
        $doctor = Doctor::with(['user:id,first_name,last_name,email,phone_number,gender'])
        ->select('id', 'user_id', 'specialization', 'availability', 'license_number', 'work_phone_number', 'bio')
        ->findOrFail($id);
    
        return new DoctorResource($doctor);
    }

    /**
     * Update a doctor's record.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->guard()->user();
        $doctor = Doctor::findOrFail($id);

        if ($user->role !== 'admin') {
            $userDoctor = Doctor::where('user_id', $user->id)->first();

            if (!$userDoctor || $userDoctor->id !== $doctor->id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $validated = $request->validate([
            'specialization' => 'sometimes|string',
            'availability' => 'sometimes|string',
            'license_number' => 'sometimes|string',
            'work_phone_number' => 'sometimes|string',
            'bio' => 'sometimes|string',
        ]);

        $doctor->update($validated);

        return response()->json([
            'message'=> 'Doctor record updated successfully',
            'doctor' => new DoctorResource($doctor->load('user')),
        ], 200);
    }


    /**
     * Remove a doctor record.
     */
    public function destroy($id)
    {
        $user = auth()->guard()->user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->json([
            'message' => 'Doctor record deleted successfully',
        ],200);
    }
}
