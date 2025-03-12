<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'baby_id' => $this->faker->numberBetween(1, 10),
            'guardian_id' => $this->faker->numberBetween(1, 10),
            'vaccine_id' => $this->faker->numberBetween(1, 5),
            'doctor_id' => $this->faker->numberBetween(1, 5),
            'appointment_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30)),
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'completed', 'cancelled']),
            'reminder_sent' => $this->faker->boolean(),
            'notes' => $this->faker->sentence(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
