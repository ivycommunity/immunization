<?php

namespace App\Http\Controllers;

use App\Models\Caregiver;
use App\Models\HospitalStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone_number' => 'required|string',
            'gender' => 'required|string',
            'role' => 'required|string',
            'nationality' => 'required|string',
            'national_id' => 'required|integer|unique:users,national_id',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'marital_status' => 'required|string',
            'next_of_kin' => 'required|string',
            'next_of_kin_contact' => 'required|string',
            'no_of_children' => 'required|integer',
        ]);

        //Create a user
        $user = User::create([
            'first_name'=> $fields['first_name'],
            'last_name'=> $fields['last_name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'phone_number' => $fields['phone_number'],
            'gender'=> $fields['gender'],
            'role'=> $fields['role'],
            'nationality'=> $fields['nationality'],
            'national_id'=> $fields['national_id'],
            'date_of_birth'=> $fields['date_of_birth'],
            'address'=> $fields['address'],
            'marital_status'=> $fields['marital_status'],
            'next_of_kin'=> $fields['next_of_kin'],
            'next_of_kin_contact'=> $fields['next_of_kin_contact'],
            'no_of_children'=> $fields['no_of_children'],
        ]);

        $token = $user->createToken($fields['first_name']);

        return [
            'user' => $user,
            'token'=> $token->plainTextToken,
        ];
    }

    public function  login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {

            return [
                'message' => 'Invalid credentials',
            ];
            
        } 

        $token = $user->createToken($user->first_name);

        return [
            'user' => $user,
            'token'=> $token->plainTextToken,
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.',
        ];
    }
}
