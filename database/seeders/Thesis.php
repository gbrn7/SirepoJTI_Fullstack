<?php

namespace Database\Seeders;

use App\Models\Thesis as ModelsThesis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Thesis extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsThesis::insert(
            [
            'id_category' => 1,
            'id_user' => 1,
            'title' => 'Big Data Indonesia',
            'file_name' => '1212.pdf',
            'abstract' => 'Big Data Indonesia',
            ],
            [
            'id_category' => 2,
            'id_user' => 1,
            'title' => 'IOT',
            'file_name' => '1212.pdf',
            'abstract' => 'IOT',
            ],
        );
    }
}
