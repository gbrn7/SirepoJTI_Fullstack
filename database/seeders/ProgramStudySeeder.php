<?php

namespace Database\Seeders;

use App\Models\ProgramStudy;
use Illuminate\Database\Seeder;

class ProgramStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramStudy::insert([
            [
                'id_majority' => 1,
                'name' => 'Teknik Informatika',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_majority' => 1,
                'name' => 'Sistem Informasi Bisnis',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
