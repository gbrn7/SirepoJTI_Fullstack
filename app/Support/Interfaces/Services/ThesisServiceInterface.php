<?php

namespace App\Support\Interfaces\Services;

use App\Models\Thesis;
use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

interface ThesisServiceInterface
{
  public function getThesis(GetThesisReqModel $reqModel, int $paginatePage = 5): Paginator;
  public function getThesisByID(string $ID): ?Thesis;
  public function getYearFilters(): Collection;
  public function getProgramStudyFilters(): Collection;
  public function getTopicFilters(): Collection;
  public function getThesisTypeFilters(): Collection;
  public function getSuggestionThesisTitle(string $searcInput): Collection;
  public function getDetailDocument(string $ID, bool|null $submissionStatus = null): ?Thesis;
  public function getDetailDocumentByStudentID(string $studentID): ?Thesis;
  public function downloadDocument(string $fileName): string|null;
  public function storeThesis(string $studentID, array $data, UploadedFile|array|null $files);
  public function processThesisFile(string $fileName, string $filePathName);
  public function updateThesis(array $reqData, string $ID, UploadedFile|array|null $files);
  public function destroyThesisByID(string $ID): bool;
  public function bulkUpdateSubmissionStatus(array $IDs, string $status, ?string $note): bool;
}
