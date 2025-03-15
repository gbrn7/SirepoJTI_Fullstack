<?php

namespace App\Services;

use App\Support\Interfaces\Repositories\ThesisTopicRepositoryInterface;
use App\Support\Interfaces\Services\ThesisTopicServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ThesisTopicService implements ThesisTopicServiceInterface
{
  public function __construct(
    protected ThesisTopicRepositoryInterface $repository
  ) {}

  public function getThesisTopics(): Collection
  {
    return $this->repository->getThesisTopics();
  }
}
