<?php

namespace App\Repositories;

use App\Models\Lecturer;
use App\Support\Interfaces\Repositories\LecturerRepositoryInterface;
use App\Support\model\GetLecturerReqModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

class LecturerRepository implements LecturerRepositoryInterface
{

  public function getLecturers(GetLecturerReqModel $params, bool $wantPaginate = true): Collection|Paginator
  {
    $query = Lecturer::query()
      ->with('topic')
      ->when($params->name, fn($q) => $q->where('name', 'like', '%' . $params->name . '%'))
      ->when($params->username, fn($q) => $q->where('username', 'like', '%' . $params->username . '%'))
      ->when($params->username, fn($q) => $q->where('email', 'like', '%' . $params->email . '%'));

    return $wantPaginate ?  $query->paginate(10) :  $query->get();
  }

  public function storeLecturer(array $data): Lecturer
  {
    $lecturer = Lecturer::create($data);

    $lecturer->assignRole('lecturer');

    return $lecturer;
  }

  public function getLecturerByID(string $ID): Lecturer
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
