<?php

namespace Database\Seeders;

use App\Models\ThesisFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThesisFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThesisFile::insert([
            [
                "thesis_id" => 1,
                "label" => "Abstrak",
                "file_name" => "Abstrak.pdf",
                "sequence_num" => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "thesis_id" => 1,
                "label" => "Bab I",
                "file_name" => "Bab_I.pdf",
                "sequence_num" => 2,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "thesis_id" => 2,
                "label" => "Abstrak",
                "file_name" => "Abstrak.pdf",
                "sequence_num" => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "thesis_id" => 2,
                "label" => "Bab I",
                "file_name" => "Bab_I.pdf",
                "sequence_num" => 2,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "thesis_id" => 3,
                "label" => "Abstrak",
                "file_name" => "Abstrak.pdf",
                "sequence_num" => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "thesis_id" => 3,
                "label" => "Bab I",
                "file_name" => "Bab_I.pdf",
                "sequence_num" => 2,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "thesis_id" => 4,
                "label" => "Abstrak",
                "file_name" => "Abstrak.pdf",
                "sequence_num" => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "thesis_id" => 4,
                "label" => "Bab I",
                "file_name" => "Bab_I.pdf",
                "sequence_num" => 2,
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}
