<?php

namespace App\Support\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ProgramStudyRepositoryInterface
{
  public function getProgramStudys(): Collection;
}
