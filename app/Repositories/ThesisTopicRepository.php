<?php

namespace App\Repositories;

use App\Models\ThesisTopic;
use App\Support\Interfaces\Repositories\ThesisTopicRepositoryInterface;
use App\Support\model\GetThesisReqModel;
use Illuminate\Database\Eloquent\Collection;

class ThesisTopicRepository implements ThesisTopicRepositoryInterface
{

  public function getThesisTopics(): Collection
  {
    return ThesisTopic::all();
  }

  public function storeThesisTopic(array $data): ThesisTopic
  {
    return ThesisTopic::create($data);
  }

  public function getThesisTopicByID(string $ID): ?ThesisTopic
  {
    return ThesisTopic::find($ID);
  }

  public function updateThesisTopic(ThesisTopic $thesisTopic, array $data): bool
  {
    return $thesisTopic->update($data);
  }

  public function deleteThesisTopic(ThesisTopic $thesisTopic): bool
  {
    return $thesisTopic->delete();
  }
}
