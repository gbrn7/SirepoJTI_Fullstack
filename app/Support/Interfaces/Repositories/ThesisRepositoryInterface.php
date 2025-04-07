<?php

namespace App\Support\Interfaces\Repositories;

use App\Models\Student;
use App\Models\Thesis;
use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface ThesisRepositoryInterface
{
  public function getThesis(GetThesisReqModel $reqModel): Paginator;
  public function getThesisbyID(string $ID): ?Thesis;
  public function getThesisByStudentID(string $studentID): Collection;
  public function destroyThesisByIDs(array $IDs): bool;
  public function getYearFilters(): Collection;
  public function getProgramStudyFilters(): Collection;
  public function getTopicFilters(): Collection;
  public function getThesisTypeFilters(): Collection;
  public function getSuggestionThesisTitle(string $searcInput): Collection;
  public function getDetailDocument(string $ID, bool|null $submissionStatus = null): Thesis | null;
  public function getDetailDocumentByStudentID(string $studentID): Thesis | null;
  public function storeThesis(array $data, array $newFiles = []): ?Thesis;
  public function updateThesis(Thesis $thesis, array $newData): ?Bool;
  public function updateOrCreateThesisFile(Thesis $thesis, array $searchParams, array $newDataFiles);
  public function deleteThesis(Thesis $thesis): bool;
  public function bulkUpdateSubmissionStatus(array $IDs, ?bool $status, ?string $note): bool;
}
