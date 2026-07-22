<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'location' => fake()->city(),
            'description' => fake()->paragraph(),
            'capacity' => fake()->numberBetween(10, 200),
        ];
    }
}