<?php

namespace App\Support\Interfaces\Repositories;

use App\Models\Lecturer;
use App\Support\model\GetLecturerReqModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

interface LecturerRepositoryInterface
{
  public function getLecturers(GetLecturerReqModel $params, bool $wantPaginate = true, string $sortBy = 'id', string $sequence = 'DESC'): Collection|Paginator;
  public function storeLecturer(array $data): Lecturer;
  public function getLecturerByID(string $ID): ?Lecturer;
  public function updateLecturer(Lecturer $lecturer, array $reqData): bool;
  public function deleteLecturer(string $ID): ?Lecturer;
  public function insertLecturers(array $data);
}
