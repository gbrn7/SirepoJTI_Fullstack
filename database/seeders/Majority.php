<?php

namespace Database\Seeders;

use App\Models\Majority as ModelsMajority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Majority extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsMajority::insert(
            [
            'name' => 'Teknologi Informasi',
            'created_at' => now(),
            'updated_at' => now()
            ],
        );
    }
}
