<?php

namespace App\Support\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ThesisTypeRepositoryInterface
{
  public function getThesisTypes(): Collection;
}
