<?php

namespace App\Repositories;

use App\Models\Lecturer;
use App\Support\Interfaces\Repositories\LecturerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LecturerRepository implements LecturerRepositoryInterface
{

  public function getLecturers(): Collection
  {
    return Lecturer::all();
  }
}
