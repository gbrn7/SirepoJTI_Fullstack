<?php

namespace App\Support\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ThesisRepositoryInterface
{
  public function getYearFilters(): Collection;
  public function getProgramStudyFilters(): Collection;
  public function getTopicFilters(): Collection;
  public function getAuthorFilters(string $alphabet = "A"): Collection;
  public function getThesisTypeFilters(): Collection;
}
