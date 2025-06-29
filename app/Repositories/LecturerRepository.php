<?php

namespace App\Repositories;

use App\Models\Lecturer;
use App\Support\Interfaces\Repositories\LecturerRepositoryInterface;
use App\Support\model\GetLecturerReqModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

class LecturerRepository implements LecturerRepositoryInterface
{

  public function getLecturers(GetLecturerReqModel $params, bool $wantPaginate = true, string $sortBy = 'id', string $sequence = 'DESC'): Collection|Paginator
  {
    $query = Lecturer::query()
      ->with('topic')
      ->when($params->name, fn($q) => $q->where('name', 'like', '%' . $params->name . '%'))
      ->when($params->username, fn($q) => $q->where('username', 'like', '%' . $params->username . '%'))
      ->when($params->email, fn($q) => $q->where('email', 'like', '%' . $params->email . '%'))
      ->orderBy($sortBy, $sequence);

    return $wantPaginate ?  $query->paginate(10) :  $query->get();
  }

  public function storeLecturer(array $data): Lecturer
  {
    $lecturer = Lecturer::create($data);

    $lecturer->assignRole('lecturer');

    return $lecturer;
  }

  public function getLecturerByID(string $ID): ?Lecturer
  {
    return Lecturer::with('topic')->find($ID);
  }

  public function updateLecturer(Lecturer $lecturer, array $reqData): bool
  {
    return $lecturer->update($reqData);
  }

  public function deleteLecturer(string $ID): ?Lecturer
  {
    $lecturer = Lecturer::find($ID);

    if (!isset($lecturer)) throw new Exception("Data Dosen Tidak Ditemukan");

    $lecturer->delete($ID);

    return $lecturer;
  }

  public function insertLecturers(array $data)
  {
    foreach ($data as $value) {
      $lecturer = Lecturer::create($value);

      $lecturer->assignRole('lecturer');
    }
  }
}
