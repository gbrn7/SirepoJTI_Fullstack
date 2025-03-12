<?php

namespace App\Services;

use App\Support\Interfaces\Services\ProgramStudyServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ProgramStudyService implements ProgramStudyServiceInterface
{
  public function __construct(
    protected ProgramStudyServiceInterface $service
  ) {}
}
