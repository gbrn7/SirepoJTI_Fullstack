<?php

namespace App\Services;

use App\Imports\LecturerImport;
use App\Models\Lecturer;
use App\Support\Interfaces\Repositories\LecturerRepositoryInterface;
use App\Support\Interfaces\Services\LecturerServiceInterface;
use App\Support\model\GetLecturerReqModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class LecturerService implements LecturerServiceInterface
{
  public function __construct(
    protected LecturerRepositoryInterface $repository
  ) {}

  public function getLecturers(?GetLecturerReqModel $reqModel = null): Collection|Paginator
  {
    $params = isset($reqModel) ? $reqModel : new GetLecturerReqModel();

    return $this->repository->getLecturers($params, true);
  }

  public function storeLecturer(array $data): Lecturer
  {
    try {
      DB::beginTransaction();

      if (isset($data['profile_picture'])) {
        // Store profile picture
        $file = $data['profile_picture'];
        $fileName = Str::random(10) . $file->getClientOriginalName();
        $file->storeAs('public/profile/', $fileName);

        $data['profile_picture'] = $fileName;
      }

      $lecturer = $this->repository->storeLecturer($data);
      DB::commit();
      return $lecturer;
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  public function getLecturerByID(string $ID): Lecturer
  {
    return $this->repository->getLecturerByID($ID);
  }

  public function updateLecturer(string $ID, array $reqData): bool
  {
    try {
      $oldData = $this->repository->getLecturerByID($ID);

      if (!isset($oldData)) throw new Exception('Data Dosen Tidak Ditemukan');

      $arrayOldData = $oldData->toArray();
      $newData = collection::make();

      if (isset($reqData['old_password']) && isset($reqData['new_password'])) {
        if (!(Hash::check($reqData['old_password'], $oldData->password))) {
          throw new Exception('Password Lama Tidak Valid');
        } else {
          $newData->put('password', $reqData['new_password']);
        }
      }

      foreach ($arrayOldData as $key => $value) {
        if ($value != ($reqData[$key] ?? $value)) {
          $newData->put($key, $reqData[$key]);
        }
      }

      if (isset($newData['profile_picture'])) {
        // Store profile picture
        $file = $reqData['profile_picture'];

        $fileName = Str::random(10) . $file->getClientOriginalName();
        $file->storeAs('public/profile/', $fileName);

        $newData['profile_picture'] = $fileName;

        // Delete old file
        Storage::delete('public/profile/' . $oldData->profile_picture);
      }

      if (isset($reqData['password'])) {
        $newData['password'] = $reqData['password'];
      }

      return $this->repository->updateLecturer($oldData, $newData->toArray());
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function deleteLecturer(string $ID): Lecturer
  {
    try {
      $lecturer = $this->repository->deleteLecturer($ID);

      if (!isset($lecturer)) throw new Exception("Dosen Tidak Ditemukan");

      Storage::delete('profile/' . $lecturer->profile_picture);
      return $lecturer;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function importExcel(string $topicID, UploadedFile|array|null $file)
  {
    try {
      $raws = Excel::toArray(new LecturerImport(), $file);

      $newData = Collection::make();

      foreach ($raws as $raw) {
        foreach ($raw as $row) {
          $newData->push([
            'name' => $row['nama'],
            'username' => $row['username'],
            'topic_id' => $topicID,
            'email' => $row['email'],
            'password' => $row['password'],
          ]);
        }
      }
      DB::beginTransaction();

      $this->repository->insertLecturers($newData->toArray());

      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }
}
