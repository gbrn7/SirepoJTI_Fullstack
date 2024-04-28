<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); //the argument is used for country code

        $user = ModelsUser::create(
            [
            'id_program_study' => 1,
            'name' => 'Farhan',
            'username' => 'farhan12',
            'email' => 'farhan123@gmail.com',
            'password' => Hash::make('userpass'),
            'created_at' => now(),
            'updated_at' => now()
            ]
        );
        $user->assignRole('user');


        for ($i=0; $i < 100; $i++) { 
            $user = ModelsUser::create([
                'id_program_study' => $faker->numberBetween(1,2),
                'name' => $faker->name(),
                'username' => $faker->userName(),
                'email' => $faker->email(),
                'password' => Hash::make('userpass'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $user->assignRole('user');
        }

    }
}
