<?php

namespace App\Support\Interfaces\Services;

use App\Models\Thesis;
use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

interface ThesisServiceInterface
{
  public function getThesis(GetThesisReqModel $reqModel): Paginator;
  public function getYearFilters(): Collection;
  public function getProgramStudyFilters(): Collection;
  public function getTopicFilters(): Collection;
  public function getAuthorFilters(?string $alphabet = "A"): Collection;
  public function getThesisTypeFilters(): Collection;
  public function getSuggestionThesisTitle(string $searcInput): Collection;
  public function getDetailDocument(string $ID): Thesis | null;
  public function downloadDocument(string $fileName): string|null;
}
