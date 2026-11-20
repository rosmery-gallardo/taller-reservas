<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'workshop_id' => Workshop::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'seats' => 1,
        ];
    }
}
