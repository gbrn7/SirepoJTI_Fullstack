<?php

namespace Database\Factories;

use App\Models\Thesis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ThesisFile>
 */
class ThesisFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thesis_id' => Thesis::inRandomOrder()->first()->id,
            'label' => fake()->sentence(),
            'file_name' => fake()->word(5) . '.pdf',
            'sequence_num' => fake()->numberBetween(1, 12),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
