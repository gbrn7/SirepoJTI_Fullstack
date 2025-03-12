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

  public function getYearFilter(): Collection
  {
    return $this->ThesisRepository->getYearFilter();
  }
}
