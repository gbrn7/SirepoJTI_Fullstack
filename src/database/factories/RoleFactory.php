<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'guard_name' => fake()->randomElements(['admin', 'lecturer', 'student'])
        ];
    }


    public function student()
    {
        return $this->state([
            'name' => 'student',
            'guard_name' => 'student'
        ]);
    }

    public function lecturer()
    {
        return $this->state([
            'name' => 'lecturer',
            'guard_name' => 'lecturer'
        ]);
    }

    public function admin()
    {
        return $this->state([
            'name' => 'admin',
            'guard_name' => 'admin'
        ]);
    }
}
