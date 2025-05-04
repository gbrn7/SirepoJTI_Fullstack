<?php

namespace Database\Factories;

use App\Models\ThesisTopic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecturer>
 */
class LecturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'topic_id' => ThesisTopic::inRandomOrder()->first()->id,
            'name' => fake()->name(),
            'username' => fake()->userName(),
            'email' => fake()->email(),
            'password' => Hash::make('lecturerpass'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
