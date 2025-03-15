<?php

namespace App\Repositories;

use App\Models\Thesis;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ThesisRepository implements ThesisRepositoryInterface
{
  public function getThesis(GetThesisReqModel $reqModel): Paginator
  {
    return DB::table('thesis as t')
      ->where('t.title', 'like', '%' . $reqModel->title . '%')
      ->when($reqModel->submissionStatus, function ($query) use ($reqModel) {
        return $query->where('t.submission_status', $reqModel->submissionStatus);
      })
      ->when($reqModel->topicID, function ($query) use ($reqModel) {
        return is_array($reqModel->topicID) ? $query->whereIn('t.topic_id', $reqModel->topicID) : $query->where('t.topic_id', $reqModel->topicID);
      })
      ->when($reqModel->typeID, function ($query) use ($reqModel) {
        return is_array($reqModel->typeID) ? $query->whereIn('tte.id', $reqModel->typeID) : $query->where('tte.id', $reqModel->typeID);
      })
      ->when($reqModel->programStudyID, function ($query) use ($reqModel) {
        return is_array($reqModel->programStudyID) ? $query->whereIn('s.program_study_id', $reqModel->programStudyID) : $query->where('s.program_study_id', $reqModel->programStudyID);
      })
      ->when($reqModel->name, function ($query) use ($reqModel) {
        return $query
          ->where('s.first_name', 'like', '%' . $reqModel->name . '%')
          ->orWhere('s.last_name', 'like', '%' . $reqModel->name . '%');
      })
      ->when($reqModel->studentID, function ($query) use ($reqModel) {
        return $query->where('t.student_id', $reqModel->studentID);
      })
      ->when($reqModel->publicationFrom, function ($query) use ($reqModel) {
        return $query->where('t.created_at', '>=', $reqModel->publicationFrom);
      })
      ->when($reqModel->publicationUntil, function ($query) use ($reqModel) {
        return $query->where('t.created_at', '<=', $reqModel->publicationUntil);
      })
      ->join('students as s', 's.id', 't.student_id')
      ->join('program_study as ps', 'ps.id', 's.program_study_id')
      ->join('thesis_topics as tt', 'tt.id', 't.topic_id')
      ->join('thesis_types as tte', 'tte.id', 't.type_id')
      ->selectRaw('t.id as thesis_id, t.student_id, s.last_name, s.first_name, t.title as thesis_title, t.abstract as thesis_abstract, ps.name as program_study_name, tt.topic as thesis_topic, t.created_at as publication, tt.id as topic_id, ps.id as program_study_id, tte.id as thesis_type_id, tte.type as thesis_type')
      ->orderBy('t.id', 'desc')
      ->paginate(5);
  }

  public function getSuggestionThesisTitle(string $searchInput): Collection
  {
    return Thesis::select('title')
      ->where('title', 'like', '%' . $searchInput . '%')
      ->orderBy('id', 'desc')
      ->limit(7)
      ->get()
      ->unique('title');
  }

  public function getDetailDocument(string $ID, bool|null $submissionStatus = null): Thesis | null
  {
    return Thesis::with('student.programStudy.majority')
      ->with('topic')
      ->when($submissionStatus, function ($query) use ($submissionStatus) {
        return $query->where('submission_status', $submissionStatus);
      })
      ->where('id', $ID)
      ->first();
  }

  public function getYearFilters(): Collection
  {
    return Thesis::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
      ->groupBy('year')
      ->orderBy('year', 'desc')
      ->get();
  }

  public function getProgramStudyFilters(): Collection
  {
    return Thesis::selectRaw('ps.id, ps.name as program, COUNT(*) as total')
      ->join('students as s', 's.id', 'thesis.student_id')
      ->join('program_study as ps', 'ps.id', 's.program_study_id')
      ->groupBy('ps.id', 'ps.name')
      ->orderBy('ps.name', 'asc')
      ->get();
  }

  public function getTopicFilters(): Collection
  {
    return Thesis::selectRaw('tt.id, tt.topic, COUNT(*) as total')
      ->join('thesis_topics as tt', 'tt.id', 'thesis.topic_id')
      ->groupBy('tt.id', 'tt.topic')
      ->orderBy('tt.topic', 'asc')
      ->get();
  }

  public function getAuthorFilters(string $alphabet = "A"): Collection
  {
    return Thesis::selectRaw('s.id, s.last_name, s.first_name, COUNT(*) as total')
      ->where('s.last_name', 'like', $alphabet . '%')
      ->join('students as s', 's.id', 'thesis.student_id')
      ->groupBy('thesis.student_id')
      ->orderBy('s.last_name', 'asc')
      ->get();
  }

  public function getThesisTypeFilters(): Collection
  {
    return Thesis::selectRaw('tt.id, tt.type, COUNT(*) as total')
      ->join('thesis_types as tt', 'tt.id', 'thesis.type_id')
      ->groupBy('thesis.type_id')
      ->orderBy('tt.type', 'asc')
      ->get();
  }
}
