<?php

namespace App\Services;

use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ThesisService implements ThesisServiceInterface
{
  public function __construct(
    protected ThesisRepositoryInterface $ThesisRepository
  ) {}

  public function getYearFilters(): Collection
  {
    return $this->ThesisRepository->getYearFilters();
  }

  public function getProgramStudyFilters(): Collection
  {
    return $this->ThesisRepository->getProgramStudyFilters();
  }

  public function getTopicFilters(): Collection
  {
    return $this->ThesisRepository->getTopicFilters();
  }

  public function getAuthorFilters(?string $alphabet = "A"): Collection
  {
    return $this->ThesisRepository->getAuthorFilters($alphabet ? $alphabet : "A");
  }

  public function getThesisTypeFilters(): Collection
  {
    return $this->ThesisRepository->getThesisTypeFilters();
  }
}
