<?php

namespace App\Support\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ThesisRepositoryInterface
{
  public function getYearFilter(): Collection;
}
