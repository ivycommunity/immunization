<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'doctor@example.com',
            'password' => Hash::make('securepassword456'), // Change this to a secure password
            'phone_number' => '0987654321',
            'gender' => 'Male',
            'role' => 'guardian',
            'nationality' => 'Unknown',
            'national_id' => null,
            'date_of_birth' => '1985-08-15',
            'address' => '456 Wellness Ave, Health Town',
            'marital_status' => 'Married',
            'next_of_kin' => 'Jane Smith',
            'next_of_kin_contact' => '1234567890',
            'no_of_children' => 2,
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);
    }
}
