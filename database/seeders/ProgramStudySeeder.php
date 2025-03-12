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
                'name' => 'D2 Pengembangan Piranti Lunak Situs',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_majority' => 1,
                'name' => 'D4 Teknik Informatika',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_majority' => 1,
                'name' => 'D4 Sistem Informasi Bisnis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_majority' => 1,
                'name' => 'S2 Rekayasa Teknologi Informasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
