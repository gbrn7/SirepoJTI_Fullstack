<?php

namespace App\Support\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ThesisTopicRepositoryInterface
{
  public function getThesisTopics(): Collection;
}
