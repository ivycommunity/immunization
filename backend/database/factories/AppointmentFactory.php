<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Baby;
use App\Models\User;
use App\Models\Vaccine;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'baby_id'           => Baby::query()->inRandomOrder()->value('id'),
            'guardian_id'       => User::query()->where('role', 'guardian')->inRandomOrder()->value('id'),
            'vaccine_id'        => Vaccine::query()->inRandomOrder()->value('id'),
            'doctor_id'         => User::query()->where('role', 'doctor')->inRandomOrder()->value('id'),
            'appointment_date'  => now()->addDays($this->faker->numberBetween(1, 30)),
            'status'            => $this->faker->randomElement(['scheduled', 'completed', 'cancelled']),
            'reminder_sent'     => $this->faker->boolean(),
            'notes'             => $this->faker->sentence(),
        ];
    }
}
