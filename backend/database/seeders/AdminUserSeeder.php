<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name'        => 'Admin',
            'last_name'         => 'User',
            'email'             => 'admin@example.com',
            'password'          => Hash::make('password123'), 
            'phone_number'      => '1234567890',
            'gender'            => 'Other',
            'role'              => 'admin',
            'nationality'       => 'Unknown',
            'national_id'       => null,
            'date_of_birth'     => '2000-01-01',
            'address'           => 'Admin HQ',
            'marital_status'    => 'Single',
            'next_of_kin'       => 'None',
            'next_of_kin_contact' => 'None',
            'no_of_children'    => 0,
            'email_verified_at' => now(),
        ]);
    }
}
