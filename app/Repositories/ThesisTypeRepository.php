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

  public function storeThesisType(array $data): ThesisType
  {
    return ThesisType::create($data);
  }

  public function getThesisTypeByID(string $ID): ThesisType
  {
    return ThesisType::find($ID);
  }

  public function updateThesisType(ThesisType $thesisType, array $data): bool
  {
    return $thesisType->update($data);
  }

  public function deleteThesisType(ThesisType $thesisType): bool
  {
    return $thesisType->delete();
  }
}
