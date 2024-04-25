<?php

namespace Database\Seeders;

use App\Models\Admin as ModelsAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsAdmin::insert(
            [
            'name' => 'Admin Sirepo-JTI',
            'username' => 'adminsirepojti',
            'email' => 'adminsirepojti@gmail.com',
            'password' => Hash::make('adminpass'),
            'created_at' => now(),
            'updated_at' => now()
            ],
        );
    }
}
