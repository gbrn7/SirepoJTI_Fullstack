<?php

namespace App\Support\Interfaces\Services;

use App\Models\Lecturer;
use App\Support\model\GetLecturerReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

interface LecturerServiceInterface
{
  public function getLecturers(?GetLecturerReqModel $reqModel = null): Collection|Paginator;
  public function storeLecturer(array $reqData): Lecturer;
  public function getLecturerByID(string $ID): Lecturer;
  public function updateLecturer(string $ID, array $reqData): bool;
  public function deleteLecturer(string $ID): Lecturer;
  public function importExcel(string $topicID, UploadedFile|array|null $file);
}
