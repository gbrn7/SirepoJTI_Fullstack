<?php

namespace App\Repositories;

use App\Models\Thesis;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ThesisRepository implements ThesisRepositoryInterface
{
  public function getYearFilters(): Collection
  {
    return Thesis::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
      ->groupBy('year')
      ->orderBy('year', 'desc')
      ->get();
  }

  public function getProgramStudyFilters(): Collection
  {
    return Thesis::selectRaw('ps.name as program, COUNT(*) as total')
      ->join('students as s', 's.id', 'thesis.student_id')
      ->join('program_study as ps', 'ps.id', 's.program_study_id')
      ->groupBy('ps.name')
      ->orderBy('ps.name', 'asc')
      ->get();
  }

  public function getTopicFilters(): Collection
  {
    return Thesis::selectRaw('tt.topic, COUNT(*) as total')
      ->join('thesis_topics as tt', 'tt.id', 'thesis.topic_id')
      ->groupBy('tt.topic')
      ->orderBy('tt.topic', 'asc')
      ->get();
  }

  public function getAuthorFilters(string $alphabet = "A"): Collection
  {
    return Thesis::selectRaw('s.last_name, s.first_name, COUNT(*) as total')
      ->where('s.last_name', 'like', $alphabet . '%')
      ->join('students as s', 's.id', 'thesis.student_id')
      ->groupBy('thesis.student_id')
      ->orderBy('s.last_name', 'asc')
      ->get();
  }

  public function getThesisTypeFilters(): Collection
  {
    return Thesis::selectRaw('tt.type, COUNT(*) as total')
      ->join('thesis_types as tt', 'tt.id', 'thesis.type_id')
      ->groupBy('thesis.type_id')
      ->orderBy('tt.type', 'asc')
      ->get();
  }
}
