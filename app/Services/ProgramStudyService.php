<?php

namespace App\Services;

use App\Models\ProgramStudy;
use App\Support\Interfaces\Repositories\ProgramStudyRepositoryInterface;
use App\Support\Interfaces\Services\ProgramStudyServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ProgramStudyService implements ProgramStudyServiceInterface
{
  public function __construct(
    protected ProgramStudyRepositoryInterface $repository
  ) {}

  public function getProgramStudys(): Collection
  {
    return $this->repository->getProgramStudys();
  }
}
