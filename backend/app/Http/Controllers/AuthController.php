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
            'role' => 'required|in:caregiver,hospital_staff',
            'phone' => 'required|string|max:15',
            'employee_id' => 'nullable|required_if:role,hospital_staff|numeric',
            'position' => 'nullable|required_if:role,hospital_staff|string',
            'relationship' => 'nullable|required_if:role,caregiver|string',
        ]);

        //Create a user
        $user = User::create([
            'first_name'=> $fields['first_name'],
            'last_name'=> $fields['last_name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'role'=> $fields['role'],
        ]);

        //Insert role specific details
        if ($fields['role'] === 'caregiver'){
            Caregiver::create([
                'user_id' => $user->id,
                'phone' => $fields['phone'],
                'relationship' => $fields['relationship'],
            ]);
        }elseif ($fields['role'] === 'hospital_staff'){
            HospitalStaff::create([
                'user_id' => $user->id,
                'employee_id' => $fields['employee_id'],
                'phone' => $fields['phone'],
                'position' => $fields['position'],
            ]);
        }

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
