<?php

namespace App\Repositories;

use App\Models\Student;
use App\Support\Interfaces\Repositories\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements StudentRepositoryInterface
{

  public function getSuggestionAuthor(string $searchInput): Collection
  {
    return Student::select('first_name', 'last_name')->where(function ($query) use ($searchInput) {
      $query->where('first_name', 'like', $searchInput . '%')
        ->orWhere('last_name', 'like', $searchInput . '%');
    })->get();
  }

  public function getAuthorFilters(string $alphabet = "A"): Collection
  {
    return Student::withCount(['thesis' => function ($query) {
      $query->where('submission_status', true);
    }])->where('last_name', 'like', $alphabet . '%')->get();
  }

  public function getStudentByUsername(string $username): ?Student
  {
    return Student::where('username', $username)->first();
  }
}
