<?php

namespace App\Support\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface LecturerRepositoryInterface
{
  public function getLecturers(): Collection;
}
