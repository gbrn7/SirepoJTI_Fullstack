<?php

namespace Database\Factories;

use App\Models\ProgramStudy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_study_id' => ProgramStudy::inRandomOrder()->first()->id,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'class_year' => fake()->year(),
            'username' => fake()->userName(),
            'email' => fake()->email(),
            'password' => Hash::make('userpass'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
