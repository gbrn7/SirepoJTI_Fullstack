<?php

namespace App\Services;

use App\Support\Interfaces\Repositories\ThesisTypeRepositoryInterface;
use App\Support\Interfaces\Services\ThesisTypeServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ThesisTypeService implements ThesisTypeServiceInterface
{
  public function __construct(
    protected ThesisTypeRepositoryInterface $repository
  ) {}

  public function getThesisTypes(): Collection
  {
    return $this->repository->getThesisTypes();
  }
}
