<?php

namespace App\Repositories;

use App\Models\ThesisTopic;
use App\Support\Interfaces\Repositories\ThesisTopicRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ThesisTopicRepository implements ThesisTopicRepositoryInterface
{

  public function getThesisTopics(): Collection
  {
    return ThesisTopic::all();
  }
}
