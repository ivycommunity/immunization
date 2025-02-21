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
            'username' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|string|in:Healthcare Provider,Parent',// Validate role
        ]);

        $roleMapping = [
            'Healthcare Provider' => 2,
            'Parent' => 3,
        ];

        //Create a user
        $user = User::create([
            'first_name'=> $fields['first_name'],
            'last_name'=> $fields['last_name'],
            'username'=> $fields['username'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'role_id' => $roleMapping[$fields['role']],// Store role_id instead of role name
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
