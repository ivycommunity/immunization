<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Baby;

use Illuminate\Http\Request;

class BabyController extends Controller
{
    /**
     * Display all the babies.
     */
    public function index()
    {
        $user = auth()->guard()->user();

        if($user->role == 'Guardian'){
            return [
                'message'=> 'Unauthorized'
            ];
        }

        $babies = Baby::all();
        return [
            'babies'=> $babies
        ];

    }


    /**
     * Store a newly created baby record.
     */
    public function store(Request $request)
    {
        $user = auth()->guard()->user();

        if($user->role !== 'Healthcare Provider'){
            return [
                'message'=> 'Unauthorized'
            ];
        }

        $validated = $request->validate([
            'first_name'=> 'required|string',
            'last_name'=> 'required|string',
            'guardian_id'=> 'required|integer|exists:users,id',
            'gender'=> 'required|string',
            'immunization_status'=> 'required|string',
            'last_vaccine_received'=> 'required|string',
            'next_appointment_date'=> 'required|date',
            'date_of_birth'=> 'required|date',
            'nationality'=> 'required|string',
        ]);

        $guardian = User::find($validated['guardian_id']);
        if ($guardian->role !== 'Guardian') {
            return [
                'message'=> 'Guardian not found'
            ];
        }

        $baby =  Baby::create($validated);
        return [
            'message'=> 'Baby record created successfully',
        ];
    }

    /**
     * Display a single baby.
     */
    public function show(string $id)
    {
        $baby = Baby::find($id);
        if (! $baby) {
            return [
                'message'=> 'Baby record not found'
            ];
        }

        return [
            'baby'=> $baby
        ];
    }


    /**
     * Update a babies records
     */
    public function update(Request $request, string $id)
    {
        $user = auth()->guard()->user();
        if ($user->role !== 'Healthcare Provider') {
            return [
                'message'=> 'Unauthorized'
            ];
        }
        $baby = Baby::find($id);
        if (! $baby) {
            return [
                'message'=> 'Baby record not found'
            ];
        }

        $validated = $request->validate([
            'first_name'=> 'sometimes|string',
            'last_name'=> 'sometimes|string',
            'guardian_id'=> 'sometimes|integer|exists:users,id',
            'gender'=> 'sometimes|string',
            'immunization_status'=> 'sometimes|string',
            'last_vaccine_received'=> 'sometimes|string',
            'next_appointment_date'=> 'sometimes|date',
            'date_of_birth'=> 'sometimes|date',
            'nationality'=> 'sometimes|string',
        ]);
        
        if ($request->has('guardian_id')) {
            $guardian = User::find($validated['guardian_id']);
            if ($guardian->role !== 'Guardian') {
                return [
                    'message'=> 'Guardian not found'
                ];
            }
        }

        $baby->update($validated);
        return [
            'message'=> 'Baby record updated successfully',
        ];
    }

    /**
     * Delete a baby record.
     */
    public function destroy(string $id)
    {
        $user = auth()->guard()->user();

        if ($user->role == 'Guardian') {
            return [
                'message'=> 'Unauthorized'
            ];
        }

        $baby = Baby::find($id);

        if (! $baby) {
            return [
                'message'=> 'Baby record not found'
            ];
        }

        $baby->delete();

        return [
            'message'=> 'Baby record deleted successfully',
        ];
    }
}
