<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'email' => 'doctor1@example.com',
                'phone_number' => '0987654321',
                'specialization' => 'Cardiology',
                'license_number' => 'DOC123456'
            ],
            [
                'first_name' => 'Alice',
                'last_name' => 'Brown',
                'email' => 'doctor2@example.com',
                'phone_number' => '0987654322',
                'specialization' => 'Neurology',
                'license_number' => 'DOC123457'
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'doctor3@example.com',
                'phone_number' => '0987654323',
                'specialization' => 'Orthopedics',
                'license_number' => 'DOC123458'
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'email' => 'doctor4@example.com',
                'phone_number' => '0987654324',
                'specialization' => 'Pediatrics',
                'license_number' => 'DOC123459'
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Wilson',
                'email' => 'doctor5@example.com',
                'phone_number' => '0987654325',
                'specialization' => 'Dermatology',
                'license_number' => 'DOC123460'
            ],
        ];

        foreach ($doctors as $data) {
            $user = User::create([
                'first_name'        => $data['first_name'],
                'last_name'         => $data['last_name'],
                'email'             => $data['email'],
                'password'          => Hash::make('securepassword456'),
                'phone_number'      => $data['phone_number'],
                'gender'            => 'Male',
                'role'              => 'doctor',
                'nationality'       => 'Unknown',
                'national_id'       => null,
                'date_of_birth'     => '1985-08-15',
                'address'           => '456 Wellness Ave, Health Town',
                'marital_status'    => 'Married',
                'next_of_kin'       => 'Jane Doe',
                'next_of_kin_contact' => '1234567890',
                'no_of_children'    => 2,
                'email_verified_at' => now(),
            ]);

            Doctor::create([
                'user_id'          => $user->id,
                'specialization'   => $data['specialization'],
                'license_number'   => $data['license_number'],
                'work_phone_number' => '0123456789',
                'bio'              => 'Experienced specialist in ' . $data['specialization'] . '.',
            ]);
        }
    }
}
