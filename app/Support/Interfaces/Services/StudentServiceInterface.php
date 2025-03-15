<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface StudentServiceInterface
{
  public function getSuggestionAuthor(string $searchInput): Collection;
}
