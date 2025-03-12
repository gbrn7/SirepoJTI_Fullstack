<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $users =
            [
                [
                    'program_study_id' => 2,
                    'first_name' => 'Ade',
                    'last_name' => 'Susilo',
                    'gender' => 'Male',
                    'class_year' => 2021,
                    'username' => 'adesusilo',
                    'email' => $faker->email(),
                    'password' => Hash::make('userpass'),
                    'thesis_status' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'program_study_id' => 2,
                    'first_name' => 'Farhan',
                    'last_name' => 'Asyam',
                    'gender' => 'Male',
                    'class_year' => 2021,
                    'username' => 'farhan12',
                    'email' => 'farhan123@gmail.com',
                    'password' => Hash::make('userpass'),
                    'thesis_status' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'program_study_id' => 3,
                    'first_name' => 'Bagus',
                    'last_name' => 'Tejo',
                    'gender' => 'Male',
                    'class_year' => 2021,
                    'username' => 'bagustejo',
                    'email' => $faker->email(),
                    'password' => Hash::make('userpass'),
                    'thesis_status' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'program_study_id' => 4,
                    'first_name' => 'Susi',
                    'last_name' => 'Pujiastuti',
                    'gender' => 'Female',
                    'class_year' => 2021,
                    'username' => 'susipujiastuti',
                    'email' => $faker->email(),
                    'password' => Hash::make('userpass'),
                    'thesis_status' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ];


        foreach ($users as $user) {
            $user = Student::create($user);

            $user->assignRole('student');
        }

        $gender = collect(["Male", "Female"]);

        for ($i = 0; $i < 20; $i++) {
            $user = Student::create([
                'program_study_id' => $faker->numberBetween(1, 2),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'gender' => $gender->random(),
                'class_year' => $faker->numberBetween(2019, 2025),
                'username' => $faker->userName(),
                'email' => $faker->email(),
                'password' => Hash::make('userpass'),
                'thesis_status' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $user->assignRole('student');
        }
    }
}
