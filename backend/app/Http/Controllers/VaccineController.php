<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaccine;

class VaccineController extends Controller
{
   /**
     * Retrieve all vaccines
     */
    public function getVaccines()
    {
        $user = auth()->guard()->user();

        if (!$user) {
            return ['message' => 'Unauthorized'];
        }

        return [
            'vaccines' => Vaccine::all()
        ];
    }

    /**
     * Retrieve Specific vaccine by ID
     */

    public function getVaccine($id)
    {
        $user = auth()->guard()->user();

        if (!$user) {
            return ['message' => 'Unauthorized'];
        }

        $vaccine = Vaccine::find($id);

        if (!$vaccine) {
            return ['message' => 'Vaccine not found'];
        }

        return [
            'vaccine' => $vaccine
        ];
    }

    
    /**
     * Add a Vaccine
     */
    public function createVaccine(Request $request)
    {
        $user = auth()->guard()->user();

        if (!$user || $user->role !== 'Doctor') {
            return ['message' => 'Unauthorized'];
        }

        $validated = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'disease_prevented' => 'required|string|max:255',
            'recommended_age' => 'required|string|max:50',
            'dosage' => 'required|string|max:100',
            'administration_method' => 'required|string|max:100'
        ]);

        Vaccine::create($validated);

        return ['message' => 'Vaccine created successfully'];
    }

    
    /**
     * Update a Vaccine
     */
    public function updateVaccine(Request $request, $id)
    {
        $user = auth()->guard()->user();

        if (!$user || $user->role !== 'Doctor') {
            return ['message' => 'Unauthorized'];
        }

        $vaccine = Vaccine::find($id);

        if (!$vaccine) {
            return ['message' => 'Vaccine not found'];
        }

        $validated = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'description' => 'required|string',
            'disease_prevented' => 'required|string|max:255',
            'recommended_age' => 'required|string|max:50',
            'dosage' => 'required|string|max:100',
            'administration_method' => 'required|string|max:100'
        ]);

        $vaccine->update($validated);

        return ['message' => 'Vaccine updated successfully'];
    }

    
    /**
     * Delete a Vaccine
     */
    public function deleteVaccine($id)
    {
        $user = auth()->guard()->user();

        if (!$user || $user->role !== 'Doctor') {
            return ['message' => 'Unauthorized'];
        }

        $vaccine = Vaccine::find($id);

        if (!$vaccine) {
            return ['message' => 'Vaccine not found'];
        }

        $vaccine->delete();

        return ['message' => 'Vaccine deleted successfully'];
    }
}
