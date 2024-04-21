<?php

namespace Database\Seeders;

use App\Models\ProgramStudy as ModelsProgramStudy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsProgramStudy::insert([
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
