<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface ProgramStudyServiceInterface
{
  public function getProgramStudys(): Collection;
}
