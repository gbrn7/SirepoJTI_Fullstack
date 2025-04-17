<?php

namespace Database\Factories;

use App\Models\Lecturer;
use App\Models\Student;
use App\Models\ThesisTopic;
use App\Models\ThesisType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thesis>
 */
class ThesisFactory extends Factory
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
            'type_id' => ThesisType::inRandomOrder()->first()->id,
            'lecturer_id' => Lecturer::inRandomOrder()->first()->id,
            'student_id' => Student::inRandomOrder()->first()->id,
            'title' => fake()->sentence(),
            'abstract' => fake()->text(),
            'download_count' => fake()->randomNumber(),
            'submission_status' => fake()->randomElement([null, 0, 1]),
            'note' => fake()->text(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
