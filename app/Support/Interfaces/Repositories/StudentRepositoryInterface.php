<?php

namespace App\Support\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface StudentRepositoryInterface
{
  public function getSuggestionAuthor(string $searchInput): Collection;
}
