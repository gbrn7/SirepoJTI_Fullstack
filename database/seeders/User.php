<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class user extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsUser::insert([
            [
            'id_program_study' => 1,
            'name' => 'Farhan',
            'username' => 'farhan12',
            'email' => 'farhan123@gmail.com',
            'password' => Hash::make('userpass'),
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'id_program_study' => 2,
            'name' => 'Khoir',
            'username' => 'khoir12',
            'email' => 'khoir123@gmail.com',
            'password' => Hash::make('userpass'),
            'created_at' => now(),
            'updated_at' => now()
            ],
        ]);
    }
}
