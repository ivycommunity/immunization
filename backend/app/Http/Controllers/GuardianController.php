<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GuardianController extends Controller
{
    //Retrieve all guardians
    public function getGuardians()
    {
        $user = auth()->guard()->user();

        if ($user->role == 'Guardian') {
            return [
                'message'=> 'Unauthorized'
            ];
        }

        $guardians = User::where('role', 'Guardian')->get();
        return [
            'guardians'=> $guardians
        ];
    }

    //Retrieve a single guardian
    public function getGuardian($id)
    {
        $user = auth()->guard()->user();

        if ($user->role == 'Guardian') {
            return [
                'message'=> 'Unauthorized'
            ];
        }
        
        $guardian = User::where('id', $id)
                        ->where('role', 'Guardian')
                        ->first();

        if (! $guardian) {
            return [
                'message'=> 'Guardian not found'
            ];
        }
        return [
            'guardian'=> $guardian
        ];
    }

    //Update guardian details
    public function updateGuardian(Request $request, $id)
    {
        $user = auth()->guard()->user(); //Retrieve the authenticated user
        
        //Find the guardian to update
        $guardian = User::where('id', $id)
                        ->where('role', 'Guardian')
                        ->first();

        if (! $guardian) {
            return [
                'message'=> 'Guardian not found'
            ];
        }

        $validated = $request->validate([
            'first_name'=> 'sometimes|string',
            'last_name'=> 'sometimes|string',
            'email'=> 'sometimes|email|unique:users,email',
            'phone_number'=> 'sometimes|string',
            'date_of_birth'=> 'sometimes|date',
            'address'=> 'sometimes|string',
            'marital_status'=> 'sometimes|string',
            'next_of_kin'=> 'sometimes|string',
            'next_of_kin_contact'=> 'sometimes|string',
            'no_of_children'=> 'sometimes|integer',
        ]);

        $guardian->update($validated);

        return [
            'message'=> 'Guardian updated successfully'
        ];
    }

    //Delete a guardian
    public function deleteGuardian($id)
    {
        $user = auth()->guard()->user(); //Retrieve the authenticated user
        
        // Only admins can delete guardians
        if ($user->role !== 'Admin') {
            return [
                'message'=> 'Unauthorized'
            ];
        }

        $guardian = User::where('id', $id)
                        ->where('role', 'Guardian')
                        ->first();
        
        if (! $guardian) {
            return [
                'message'=> 'Guardian not found'
            ];
        }

        $guardian->delete();

        return [
            'message'=> 'Guardian deleted successfully',
        ];
    }

}
