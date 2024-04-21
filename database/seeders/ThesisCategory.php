<?php

namespace Database\Seeders;

use App\Models\ThesisCategory as ModelsThesisCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThesisCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsThesisCategory::insert([
            [
            'category' => 'Big Data',
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'category' => 'Internet Of Thing',
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'category' => 'Business Inteligence',
            'created_at' => now(),
            'updated_at' => now()
            ],
        ]);
    }
}
