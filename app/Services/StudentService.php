<?php

namespace App\Services;

use App\Support\Interfaces\Repositories\StudentRepositoryInterface;
use App\Support\Interfaces\Services\StudentServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentService implements StudentServiceInterface
{

  public function __construct(protected StudentRepositoryInterface $repository) {}

  public function getSuggestionAuthor(string $searchInput): Collection
  {
    return $this->repository->getSuggestionAuthor($searchInput);
  }
}
