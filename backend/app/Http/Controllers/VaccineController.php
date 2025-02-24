<?php

namespace App\Http\Controllers;
use App\Models\Vaccine;
use App\Models\User;

use Illuminate\Http\Request;

class VaccineController extends Controller
{
    /**
     * Display a listing of vaccines.
     */
    public function index()
    {
        $user = auth()->guard()->user();

        if ($user->role == 'Guardian') {
            return [
                'message'=> 'Unauthorized'
            ];
        }

        $vaccines = Vaccine::all();
        return [
            'message'=> 'Vaccines retrieved successfully',
            'vaccines'=> $vaccines,
        ];
    }

    /**
     * Store a newly created vaccine record
     */
    public function store(Request $request)
    {
        $user = auth()->guard()->user();

        if ($user->role !== "Admin") {
            return [
                "message"=> "Unauthorized",
            ];
        }

        $validated = $request->validate([
            'vaccine_name'=> 'required|string',
            'description'=> 'required|string',
            'disease_prevented'=> 'required|string',
            'recommended_age'=> 'required|string',
            'dosage'=> 'required|string',
            'administration_method'=> 'required|string',
        ]);

        $vaccine = Vaccine::create($validated);

        return [
            'message'=> 'Vaccine created successfully',
        ];
        
    }

    /**
     * Display the specified vaccine record.
     */
    public function show(string $id)
    {
        $user = auth()->guard()->user();

        if ($user->role == 'Guardian') {
            return [
                'message'=> 'Unauthorized'
            ];
        }

        $vaccine = Vaccine::findOrFail($id);
        return [
            'vaccine'=> $vaccine,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth()->guard()->user();

        if ($user->role == 'Guardian') {
            return [
                'message'=> 'Unauthorized'
            ];
        }

        $vaccine = Vaccine::findOrFail($id);

        $validated = $request->validate([
            'vaccine_name'=> 'sometimes|string',
            'description'=> 'sometimes|string',
            'disease_prevented'=> 'sometimes|string',
            'recommended_age'=> 'sometimes|string',
            'dosage'=> 'sometimes|string',
            'administration_method'=> 'sometimes|string',
        ]);

        $vaccine->update($validated);

        return [
            'message'=> 'Vaccine updated successfully',
        ];
    }

    /**
     * Delete a vaccine record.
     */
    public function destroy(string $id)
    {
        $user = auth()->guard()->user();

        if ($user->role !== 'Admin') {
            return [
                'message'=> 'Unauthorized',
            ];
        }

        $vaccine = Vaccine::findOrFail($id);
        $vaccine->delete();

        return [
            'message'=> 'Vaccine deleted successfully',
        ];
    }
}
