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

        // Predefined Guardians and Babies
        $guardians = [
            ['first_name' => 'David', 'last_name' => 'Okafor', 'email' => 'guardian1@example.com'],
            ['first_name' => 'Amina', 'last_name' => 'Yusuf', 'email' => 'guardian2@example.com'],
            ['first_name' => 'Samuel', 'last_name' => 'Eze', 'email' => 'guardian3@example.com'],
            ['first_name' => 'Grace', 'last_name' => 'Abubakar', 'email' => 'guardian4@example.com'],
            ['first_name' => 'Peter', 'last_name' => 'Nwankwo', 'email' => 'guardian5@example.com'],
        ];

        $babies = [
            ['first_name' => 'Chinedu', 'guardian_index' => 0],
            ['first_name' => 'Adaeze', 'guardian_index' => 0],
            ['first_name' => 'Ibrahim', 'guardian_index' => 1],
            ['first_name' => 'Fatima', 'guardian_index' => 1],
            ['first_name' => 'Kelechi', 'guardian_index' => 2],
            ['first_name' => 'Amarachi', 'guardian_index' => 2],
            ['first_name' => 'Yusuf', 'guardian_index' => 3],
            ['first_name' => 'Zainab', 'guardian_index' => 3],
            ['first_name' => 'Emeka', 'guardian_index' => 4],
            ['first_name' => 'Oluchi', 'guardian_index' => 4],
        ];

        // Create Guardians
        $guardianRecords = [];
        foreach ($guardians as $index => $guardian) {
            $guardianRecords[$index] = User::create([
                'first_name'        => $guardian['first_name'],
                'last_name'         => $guardian['last_name'],
                'email'             => $guardian['email'],
                'password'          => Hash::make('password123'),
                'phone_number'      => '070000000' . ($index + 1),
                'gender'            => ($index % 2 == 0) ? 'Male' : 'Female',
                'role'              => 'guardian',
                'nationality'       => 'Nigeria',
                'national_id'       => "GID" . ($index + 1) . "123456",
                'date_of_birth'     => '1985-06-15',
                'address'           => 'Guardian Street, City',
                'marital_status'    => 'Married',
                'next_of_kin'       => "Kin" . ($index + 1),
                'next_of_kin_contact' => '070111111' . ($index + 1),
                'no_of_children'    => rand(1, 3),
                'email_verified_at' => now(),
            ]);
        }

        // Create Babies for Each Guardian
        foreach ($babies as $baby) {
            Baby::create([
                'first_name'            => $baby['first_name'],
                'guardian_id'           => $guardianRecords[$baby['guardian_index']]->id,
                'gender'                => (rand(0, 1) ? 'Male' : 'Female'),
                'immunization_status'   => ['Up to date', 'Pending', 'Overdue'][rand(0, 2)],
                'last_vaccine_received' => !empty($vaccines) ? $vaccines[array_rand($vaccines)] : null,
                'next_appointment_date' => now()->addDays(rand(5, 30)),
                'date_of_birth'         => now()->subYears(rand(1, 5))->format('Y-m-d'),
                'nationality'           => 'Nigeria',
            ]);
        }
    }
}
