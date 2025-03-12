<?php

namespace App\Repositories;

use App\Models\Thesis;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ThesisRepository implements ThesisRepositoryInterface
{
  public function getYearFilter(): Collection
  {
    return Thesis::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
      ->groupBy('year')
      ->orderBy('year', 'desc')
      ->get();
  }
}
