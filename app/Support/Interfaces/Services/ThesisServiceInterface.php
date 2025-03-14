<?php

namespace App\Support\Interfaces\Services;

use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface ThesisServiceInterface
{
  public function getThesis(GetThesisReqModel $reqModel): Paginator;
  public function getYearFilters(): Collection;
  public function getProgramStudyFilters(): Collection;
  public function getTopicFilters(): Collection;
  public function getAuthorFilters(?string $alphabet = "A"): Collection;
  public function getThesisTypeFilters(): Collection;
}
