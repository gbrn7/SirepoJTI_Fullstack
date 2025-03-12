<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface ThesisServiceInterface
{
  public function getYearFilter(): Collection;
}
