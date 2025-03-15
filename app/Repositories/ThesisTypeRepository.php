<?php

namespace App\Repositories;

use App\Models\ThesisType;
use App\Support\Interfaces\Repositories\ThesisTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ThesisTypeRepository implements ThesisTypeRepositoryInterface
{

  public function getThesisTypes(): Collection
  {
    return ThesisType::all();
  }
}
