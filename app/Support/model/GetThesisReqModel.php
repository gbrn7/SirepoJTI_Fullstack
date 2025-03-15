<?php

namespace App\Support\model;

use Carbon\Carbon;
use Illuminate\Http\Request;

class GetThesisReqModel
{
  public string|null $title;
  public array|string|null $programStudyID;
  public array|string|null $topicID;
  public array|string|null $typeID;
  public string|null $name;
  public string|null $studentID;
  public bool|null $submissionStatus;
  public string|null $publicationFrom;
  public string|null $publicationUntil;

  public function __construct(Request $request)
  {
    $this->title = $request->title;
    $this->programStudyID = $request->program_study_id;
    $this->topicID = $request->topic_id;
    $this->typeID = $request->type_id;
    $this->name = $request->author;
    $this->submissionStatus = $request->submissionStatus;
    $this->studentID = $request->student_id;
    $this->publicationFrom = $request->publication_from ? Carbon::createFromDate($request->publication_from, 1)->startOfYear() : null;
    $this->publicationUntil = $request->publication_until ? Carbon::createFromDate($request->publication_until, 1)->endOfYear() : null;
  }
}
