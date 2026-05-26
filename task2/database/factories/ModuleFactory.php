<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;
use function Laravel\Prompts\number;

/**
 * @extends Factory<Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'credits' => fake()->numberBetween(20,40),
            'level' => fake()->numberBetween(4, 6),
            'is_completed' => fake()->boolean()
        ];
    }
}
