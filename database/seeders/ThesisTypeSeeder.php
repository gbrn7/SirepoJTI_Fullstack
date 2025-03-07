<?php

namespace Database\Seeders;

use App\Models\ThesisType;
use Illuminate\Database\Seeder;

class ThesisTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThesisType::insert([
            [
                'type' => 'Tugas Akhir',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'Skripsi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'Tesis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'type' => 'Desertasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
