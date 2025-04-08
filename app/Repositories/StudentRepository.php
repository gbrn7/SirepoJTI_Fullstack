<?php

namespace App\Repositories;

use App\Models\Student;
use App\Support\Enums\SubmissionStatusEnum;
use App\Support\Interfaces\Repositories\StudentRepositoryInterface;
use App\Support\model\GetStudentReqModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

class StudentRepository implements StudentRepositoryInterface
{

  public function getStudents(GetStudentReqModel $reqModel): Paginator
  {
    return  Student::query()
      ->with('thesis')
      ->when(
        $reqModel->name,
        fn($q) =>
        $q->whereRaw("CONCAT(first_name, ' ', last_name) like '%" . $reqModel->name . "%'")
      )
      ->when($reqModel->username, fn($q) => $q->where('username', 'like', '%' . $reqModel->username . '%'))
      ->when($reqModel->classYear, fn($q) => $q->where('class_year', $reqModel->classYear))
      ->when($reqModel->programStudyID, fn($q) => $q->where('program_study_id', $reqModel->programStudyID))
      ->when($reqModel->submissionStatus, function ($query) use ($reqModel) {
        switch ($reqModel->submissionStatus) {
          case SubmissionStatusEnum::ACCEPTED->value:
            return $query->whereRelation('thesis', 'submission_status', true);
            break;
          case SubmissionStatusEnum::DECLINED->value:
            return $query->whereRelation('thesis', 'submission_status', false);
            break;
          case SubmissionStatusEnum::UNSUBMITED->value:
            return $query->doesntHave('thesis');
            break;
          default:
            return $query->whereRelation('thesis', 'submission_status', null);
            break;
        }
      })
      ->orderBy('id', 'DESC')
      ->paginate(10);
  }

  public function getStudentByID(string $ID): ?Student
  {
    return Student::with('thesis')->with('programStudy.majority')->find($ID);
  }

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

  public function storeStudent(array $data): Student
  {
    return Student::create($data);
  }

  public function updateStudent(string $ID, array $reqData)
  {
    return Student::find($ID)->update($reqData);
  }

  public function deleteStudent(string $ID): ?Student
  {
    $student = Student::find($ID);

    $student->delete($ID);

    return $student;
  }
}
