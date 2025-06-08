<?php

namespace App\Support\Interfaces\Repositories;

use App\Models\Student;
use App\Support\model\GetStudentReqModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection as SupportCollection;

interface StudentRepositoryInterface
{
  public function getStudents(GetStudentReqModel $reqModel, ?int $paginatorPage = 10): Paginator|SupportCollection;
  public function getStudentByID(string $ID): ?Student;
  public function getSuggestionAuthor(string $searchInput): Collection;
  public function getAuthorFilters(string $alphabet = "A"): Collection;
  public function getStudentByUsername(string $username): ?Student;
  public function storeStudent(array $data): Student;
  public function updateStudent(Student $student, array $reqData);
  public function deleteStudent(string $ID): ?Student;
  public function insertStudents(array $data);
}
