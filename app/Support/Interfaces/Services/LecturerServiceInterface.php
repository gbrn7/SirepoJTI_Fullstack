<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

interface LecturerServiceInterface
{
  public function getLecturers(): Collection;
}
