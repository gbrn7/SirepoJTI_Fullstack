<?php

namespace App\Support\Interfaces\Repositories;

use App\Models\Thesis;
use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

interface ThesisRepositoryInterface
{
  public function getThesis(GetThesisReqModel $reqModel): Paginator;
  public function getYearFilters(): Collection;
  public function getProgramStudyFilters(): Collection;
  public function getTopicFilters(): Collection;
  public function getAuthorFilters(string $alphabet = "A"): Collection;
  public function getThesisTypeFilters(): Collection;
  public function getSuggestionThesisTitle(string $searcInput): Collection;
  public function getDetailDocument(string $ID, bool|null $submissionStatus = null): Thesis | null;
}
