<?php

namespace App\Support\Interfaces\Repositories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

interface StudentRepositoryInterface
{
  public function getSuggestionAuthor(string $searchInput): Collection;
  public function getAuthorFilters(string $alphabet = "A"): Collection;
  public function getStudentByUsername(string $username): ?Student;
}
