<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NurseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name'        => 'Jane',
            'last_name'         => 'Doe',
            'email'             => 'nurse@example.com',
            'password'          => Hash::make('password123'),
            'phone_number'      => '1234567890',
            'gender'            => 'Female',
            'role'              => 'nurse',
            'nationality'       => 'Unknown',
            'national_id'       => null,
            'date_of_birth'     => '1990-05-10',
            'address'           => '123 Health St, Medical City',
            'marital_status'    => 'Single',
            'next_of_kin'       => 'John Doe',
            'next_of_kin_contact' => '9876543210',
            'no_of_children'    => 0,
            'email_verified_at' => now(),
        ]);
    }
}
