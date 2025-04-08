<?php

namespace App\Services;

use App\Imports\StudentImport;
use App\Models\Student;
use App\Support\Interfaces\Repositories\StudentRepositoryInterface;
use App\Support\Interfaces\Services\StudentServiceInterface;
use App\Support\model\GetStudentReqModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentService implements StudentServiceInterface
{

  public function __construct(protected StudentRepositoryInterface $repository) {}

  public function getStudents(GetStudentReqModel $reqModel): Paginator
  {
    return $this->repository->getStudents($reqModel);
  }

  public function getStudentByID(string $ID): ?Student
  {
    return $this->repository->getStudentByID($ID);
  }

  public function getSuggestionAuthor(string $searchInput): Collection
  {
    return $this->repository->getSuggestionAuthor($searchInput);
  }

  public function getAuthorFilters(?string $alphabet = "A"): Collection
  {
    $students = $this->repository->getAuthorFilters($alphabet ? $alphabet : "A");

    return $students;
  }

  public function getStudentByUsername(string $username): ?Student
  {
    return $this->repository->getStudentByUsername($username);
  }

  public function storeStudent(array $data)
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

      $user = $this->repository->storeStudent($data);

      $user->assignRole('student');
      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  public function updateStudent(string $ID, array $reqData)
  {
    try {
      $oldData = $this->repository->getStudentByID($ID);

      if (!isset($oldData)) throw new Exception('Data Mahasiswa Tidak Ditemukan');

      $arrayOldData = $oldData->toArray();
      $newData = collection::make();

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

      $oldData->update($newData->toArray());
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function deleteStudent(string $ID)
  {
    try {
      $student = $this->repository->deleteStudent($ID);

      if (!isset($student)) throw new Exception("Mahasiswa Tidak Ditemukan");

      Storage::delete('profile/' . $student->profile_picture);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function importExcel(string $programStudyID, UploadedFile|array|null $file)
  {
    try {
      DB::beginTransaction();
      Excel::import(new StudentImport($programStudyID), $file);

      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }
}
