<?php

namespace Database\Seeders;

use App\Models\Admin;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $user = Admin::create(
            [
                'name' => 'Admin Sirepo-JTI',
                'username' => 'adminsirepojti',
                'email' => 'adminsirepojti@gmail.com',
                'password' => Hash::make('adminpass'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        );
        $user->assignRole('admin');


        for ($i = 0; $i < 3; $i++) {
            $user = Admin::create([
                'name' => $faker->name(),
                'username' => $faker->userName(),
                'email' => $faker->email(),
                'password' => Hash::make('adminpass'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $user->assignRole('admin');
        }
    }
}
