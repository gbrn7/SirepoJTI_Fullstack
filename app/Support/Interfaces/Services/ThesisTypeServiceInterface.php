<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface ThesisTypeServiceInterface
{
  public function getThesisTypes(): Collection;
}
