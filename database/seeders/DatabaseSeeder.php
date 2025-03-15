<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Thesis;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ThesisTypeSeeder::class,
            ThesisTopicSeeder::class,
            MajoritySeeder::class,
            ProgramStudySeeder::class,
            RolePermissionSeeder::class,
            StudentSeeder::class,
            AdminSeeder::class,
            LecturerSeeder::class,
            ThesisSeeder::class,
            ThesisFileSeeder::class,
        ]);
    }
}
