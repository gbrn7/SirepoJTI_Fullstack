<?php

namespace App\Support\Interfaces\Services;

use App\Models\Student;
use App\Support\model\GetStudentReqModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;

interface StudentServiceInterface
{
  public function getStudents(GetStudentReqModel $reqModel): Paginator;
  public function getStudentByID(string $ID): ?Student;
  public function getSuggestionAuthor(string $searchInput): Collection;
  public function getAuthorFilters(?string $alphabet = "A"): Collection;
  public function getStudentByUsername(string $username): ?Student;
  public function storeStudent(array $reqData);
  public function updateStudent(string $ID, array $reqData);
  public function deleteStudent(string $ID);
  public function importExcel(string $programStudyID, UploadedFile|array|null $file);
}
