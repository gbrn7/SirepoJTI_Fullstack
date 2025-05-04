<?php

namespace Database\Factories;

use App\Models\Majority;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramStudy>
 */
class ProgramStudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_majority' => Majority::inRandomOrder()->first()->id,
            'name' => fake()->name(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
