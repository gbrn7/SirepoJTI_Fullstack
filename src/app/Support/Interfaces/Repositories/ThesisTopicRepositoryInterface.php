<?php

namespace App\Support\Interfaces\Repositories;

use App\Models\ThesisTopic;
use Illuminate\Database\Eloquent\Collection;

interface ThesisTopicRepositoryInterface
{
  public function getThesisTopics(): Collection;
  public function storeThesisTopic(array $data): ThesisTopic;
  public function getThesisTopicByID(string $ID): ?ThesisTopic;
  public function updateThesisTopic(ThesisTopic $thesisTopic, array $data): bool;
  public function deleteThesisTopic(ThesisTopic $thesisTopic): bool;
  public function getThesisTopicByTopicName(string $topicName): ?ThesisTopic;
}
