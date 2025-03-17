<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;


class GuardianController extends Controller
{
    /**
     * Return all the guardians
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGuardians()
{
    $user = auth()->guard()->user();

    if (in_array($user->role, ['guardian', 'parent'])) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    $guardians = User::where('role', 'guardian')->get(['id', 'first_name', 'last_name']); 

    return response()->json([
        'guardians' => $guardians,
        'total' => $guardians->count()
    ]);
}


    /**
     * Retrieve a single guardian
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGuardian($id)
    {
        $user = auth()->guard()->user();
        
        $guardian = User::where('id', $id)
                        ->where('role', 'guardian')
                        ->first();

        if (! $guardian) {
            return response()->json(['message'=> 'Guardian/Parent record not found'], 404);
        }
        return response()->json(new UserResource($guardian));
    }

    /**
     *Update a guardian's records
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateGuardian(Request $request, $id)
    {
        $user = auth()->guard()->user(); 
        
        $guardian = User::where('id', $id)
                        ->where('role', 'guardian')
                        ->first();

        if (! $guardian) {
            return response()->json(['message'=> 'Guardian/Parent not found'],404);
        }

        $validated = $request->validate([
            'first_name'=> 'sometimes|string',
            'last_name'=> 'sometimes|string',
            'email'=> 'sometimes|email|unique:users,email',
            'password'=> 'sometimes|min:8|confirmed',
            'phone_number'=> 'sometimes|string',
            'date_of_birth'=> 'sometimes|date',
            'address'=> 'sometimes|string',
            'marital_status'=> 'sometimes|string',
            'next_of_kin'=> 'sometimes|string',
            'next_of_kin_contact'=> 'sometimes|string',
            'no_of_children'=> 'sometimes|integer',
        ]);

        $guardian->update($validated);

        return response()->json([
            'message'=> 'Guardian/Parent record updated successfully',
            'guardian'=> new UserResource($guardian)
        ]);
    }

    /**
     * Delete a guardian record
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteGuardian($id)
    {
        $user = auth()->guard()->user(); 
        
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $guardian = User::where('id', $id)
                        ->where('role', 'guardian')
                        ->first();
        
        if (! $guardian) {
            return response()->json([
                'message' => 'Guardian/Parent record not found'
            ], 404);
        }

        $guardian->delete();

        return response()->json([
            'message'=> 'Guardian/Parent record deleted successfully',
        ]);
    }

}
