<?php

namespace Database\Seeders;

use App\Models\ThesisTopic;
use Illuminate\Database\Seeder;

class ThesisTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThesisTopic::insert([
            [
                "topic" => "Kecerdasan Buatan",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "topic" => "Sistem Informasi",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "topic" => "Data",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}
