<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lecturer::create([
            "topic_id" => 1,
            "name" => "Usman Nurhasan",
            "username" => "usmannurhasan",
            "email" => "usmen@gmail.com",
            "password" => Hash::make("userpass"),
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
