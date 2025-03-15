<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface ThesisTopicServiceInterface
{
  public function getThesisTopics(): Collection;
}
