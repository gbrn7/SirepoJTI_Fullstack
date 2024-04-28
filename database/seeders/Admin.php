<?php

namespace Database\Seeders;

use App\Models\Admin as ModelsAdmin;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); //the argument is used for country code

        $user = ModelsAdmin::create(
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


        for ($i=0; $i < 3; $i++) { 
            $user = ModelsAdmin::create([
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
