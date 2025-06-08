<?php

namespace App\Support\Interfaces\Repositories;

use App\Models\ThesisType;
use Illuminate\Database\Eloquent\Collection;

interface ThesisTypeRepositoryInterface
{
  public function getThesisTypes(): Collection;
  public function storeThesisType(array $data): ThesisType;
  public function getThesisTypeByID(string $ID): ?ThesisType;
  public function updateThesisType(ThesisType $thesisType, array $data): bool;
  public function deleteThesisType(ThesisType $thesisType): bool;
  public function getThesisTypeByTypeName(string $typeName): ?ThesisType;
}
