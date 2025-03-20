<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Baby;
use App\Models\Vaccine;

class UserAndBabySeeder extends Seeder
{
    public function run(): void
    {
        // Fetch all vaccines from the database
        $vaccines = Vaccine::pluck('vaccine_name')->toArray();

        // Create Guardians
        $guardians = [];
        for ($i = 1; $i <= 5; $i++) {
            $guardian = User::create([
                'first_name'        => "Guardian{$i}",
                'last_name'         => "Doe{$i}",
                'email'             => "guardian{$i}@example.com",
                'password'          => Hash::make('password123'),
                'phone_number'      => '070000000' . $i,
                'gender'            => 'Male',
                'role'              => 'guardian',
                'nationality'       => 'Nigeria',
                'national_id'       => "GID{$i}123456",
                'date_of_birth'     => '1985-06-15',
                'address'           => 'Guardian Street, City',
                'marital_status'    => 'Married',
                'next_of_kin'       => "Kin{$i}",
                'next_of_kin_contact' => '070111111' . $i,
                'no_of_children'    => rand(1, 3),
                'email_verified_at' => now(),
            ]);
            $guardians[] = $guardian;
        }

        // Create Babies for Each Guardian
        foreach ($guardians as $guardian) {
            for ($j = 1; $j <= 2; $j++) {
                Baby::create([
                    'first_name'            => "Baby{$j}",
                    // 'last_name'             => $guardian->last_name,
                    'guardian_id'           => $guardian->id,
                    'gender'                => (rand(0, 1) ? 'Male' : 'Female'),
                    'immunization_status'   => ['Up to date', 'Pending', 'Overdue'][rand(0, 2)],
                    'last_vaccine_received' => !empty($vaccines) ? $vaccines[array_rand($vaccines)] : null,
                    'next_appointment_date' => now()->addDays(rand(5, 30)),
                    'date_of_birth'         => now()->subYears(rand(1, 5))->format('Y-m-d'),
                    'nationality'           => $guardian->nationality,
                ]);
            }
        }
    }
}
