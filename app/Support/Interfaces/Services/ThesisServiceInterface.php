<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface ThesisServiceInterface
{
  public function getYearFilters(): Collection;
  public function getProgramStudyFilters(): Collection;
  public function getTopicFilters(): Collection;
  public function getAuthorFilters(?string $alphabet = "A"): Collection;
  public function getThesisTypeFilters(): Collection;
}
