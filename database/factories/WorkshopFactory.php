<?php

namespace Database\Factories;

use App\Enums\Discipline;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Workshop>
 */
class WorkshopFactory extends Factory
{
    public function definition(): array
    {
        $title = 'Taller de '.fake()->unique()->words(3, true);

        return [
            'title' => Str::ucfirst($title),
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'discipline' => fake()->randomElement(Discipline::cases()),
            'instructor' => fake()->name(),
            'starts_at' => now()->addDays(fake()->numberBetween(3, 60))->setTime(18, 0),
            'duration_minutes' => fake()->randomElement([90, 120, 180]),
            'capacity' => 12,
            'price_cents' => fake()->randomElement([2500, 3500, 4500]),
        ];
    }

    public function full(): static
    {
        return $this->state(fn () => ['capacity' => 0]);
    }

    public function past(): static
    {
        return $this->state(fn () => ['starts_at' => now()->subWeek()]);
    }
}
