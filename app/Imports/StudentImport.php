<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToCollection, WithHeadingRow
{
    public function __construct(string $program_study_id)
    {
        $this->program_study_id = $program_study_id;
    }

    public string $program_study_id;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $parts = explode(' ', $row['nama']);

            $last_name = array_pop($parts);
            $first_name = count($parts) > 0 ? implode(' ', $parts) : "";

            $user =  Student::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $row['username'],
                'gender' => $row['jenis_kelamin_malefemale'],
                'class_year' => $row['tahun_angkatan'],
                'email' => $row['email'],
                'password' => $row['password'],
                'program_study_id' => $this->program_study_id
            ]);

            $user->assignRole('student');
        }
    }
}
