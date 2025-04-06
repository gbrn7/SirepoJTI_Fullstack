<?php

namespace App\Services;

use App\Support\Interfaces\Repositories\LecturerRepositoryInterface;
use App\Support\Interfaces\Services\LecturerServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class LecturerService implements LecturerServiceInterface
{
  public function __construct(
    protected LecturerRepositoryInterface $repository
  ) {}

  public function getLecturers(): Collection
  {
    return $this->repository->getLecturers();
  }
}
