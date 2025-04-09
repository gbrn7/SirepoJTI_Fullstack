<?php

namespace App\Support\Interfaces\Services;

use App\Models\ThesisTopic;
use Illuminate\Database\Eloquent\Collection;

interface ThesisTopicServiceInterface
{
  public function getThesisTopics(): Collection;
  public function storeThesisTopic(array $data): ThesisTopic;
  public function updateThesisTopic(string $ID, array $data): bool;
  public function deleteThesisTopic(string $ID): bool;
}
