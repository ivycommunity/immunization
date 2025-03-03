<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baby;

class BabyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Baby::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'guardian_id' => 'required|exists:users,id',
            'gender' => 'required|string|in:Male,Female,Other',
            'immunization_status' => 'required|string|max:255',
            'last_vaccine_received' => 'nullable|string|max:255',
            'next_appointment_date' => 'nullable|date',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
        ]);

        $baby = Baby::create($validatedData);
        return response()->json($baby, 201);
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
}

