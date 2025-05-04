<?php

namespace Database\Seeders;

use App\Models\Majority;
use Illuminate\Database\Seeder;

class MajoritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Majority::insert(
            [
                'name' => 'Teknologi Informasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
        );
    }
}
