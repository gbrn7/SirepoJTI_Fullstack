<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function __construct(string $program_study_id)
    {
        $this->program_study_id = $program_study_id;
    }

    public string $program_study_id;

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        {
            User::create([
                'name' => $row['name'],  
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => $row['password'],
                'id_program_study' => $this->program_study_id
            ]);
        }
    }
}
