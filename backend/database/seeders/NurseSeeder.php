<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NurseSeeder extends Seeder
{
    public function run(): void
    {
        $nurses = [
            [
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
            ],
            [
                'first_name'        => 'Anna',
                'last_name'         => 'Smith',
                'email'             => 'nurse1@example.com',
                'password'          => Hash::make('password123'),
                'phone_number'      => '1234567891',
                'gender'            => 'Female',
                'role'              => 'nurse',
                'nationality'       => 'Unknown',
                'national_id'       => null,
                'date_of_birth'     => '1988-03-22',
                'address'           => '124 Health St, Medical City',
                'marital_status'    => 'Married',
                'next_of_kin'       => 'Peter Smith',
                'next_of_kin_contact' => '9876543211',
                'no_of_children'    => 1,
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Emily',
                'last_name'         => 'Jones',
                'email'             => 'nurse2@example.com',
                'password'          => Hash::make('password123'),
                'phone_number'      => '1234567892',
                'gender'            => 'Female',
                'role'              => 'nurse',
                'nationality'       => 'Unknown',
                'national_id'       => null,
                'date_of_birth'     => '1992-07-15',
                'address'           => '125 Health St, Medical City',
                'marital_status'    => 'Single',
                'next_of_kin'       => 'Robert Jones',
                'next_of_kin_contact' => '9876543212',
                'no_of_children'    => 0,
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Olivia',
                'last_name'         => 'Brown',
                'email'             => 'nurse3@example.com',
                'password'          => Hash::make('password123'),
                'phone_number'      => '1234567893',
                'gender'            => 'Female',
                'role'              => 'nurse',
                'nationality'       => 'Unknown',
                'national_id'       => null,
                'date_of_birth'     => '1987-11-30',
                'address'           => '126 Health St, Medical City',
                'marital_status'    => 'Married',
                'next_of_kin'       => 'Michael Brown',
                'next_of_kin_contact' => '9876543213',
                'no_of_children'    => 2,
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Sophia',
                'last_name'         => 'Williams',
                'email'             => 'nurse4@example.com',
                'password'          => Hash::make('password123'),
                'phone_number'      => '1234567894',
                'gender'            => 'Female',
                'role'              => 'nurse',
                'nationality'       => 'Unknown',
                'national_id'       => null,
                'date_of_birth'     => '1995-02-20',
                'address'           => '127 Health St, Medical City',
                'marital_status'    => 'Single',
                'next_of_kin'       => 'Laura Williams',
                'next_of_kin_contact' => '9876543214',
                'no_of_children'    => 0,
                'email_verified_at' => now(),
            ],
            [
                'first_name'        => 'Chloe',
                'last_name'         => 'Davis',
                'email'             => 'nurse5@example.com',
                'password'          => Hash::make('password123'),
                'phone_number'      => '1234567895',
                'gender'            => 'Female',
                'role'              => 'nurse',
                'nationality'       => 'Unknown',
                'national_id'       => null,
                'date_of_birth'     => '1991-09-12',
                'address'           => '128 Health St, Medical City',
                'marital_status'    => 'Married',
                'next_of_kin'       => 'David Davis',
                'next_of_kin_contact' => '9876543215',
                'no_of_children'    => 1,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($nurses as $nurse) {
            User::create($nurse);
        }
    }
}
