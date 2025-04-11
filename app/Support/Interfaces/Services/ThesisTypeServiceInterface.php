<?php

namespace App\Support\Interfaces\Services;

use App\Models\ThesisType;
use Illuminate\Database\Eloquent\Collection;

interface ThesisTypeServiceInterface
{
  public function getThesisTypes(): Collection;
  public function storeThesisType(array $data): ThesisType;
  public function updateThesisType(string $ID, array $data): bool;
  public function deleteThesisType(string $ID): bool;
}
