<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VaccineSeeder::class,
            AdminUserSeeder::class,
            DoctorSeeder::class,         
            NurseSeeder::class,
            UserAndBabySeeder::class,
            AppointmentsTableSeeder::class,
        ]);
    }
}
