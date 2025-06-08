<?php

namespace App\Support\model;

use Illuminate\Http\Request;

class GetStudentReqModel
{
  public ?string $ID;
  public ?string $name;
  public ?string $username;
  public ?string $classYear;
  public ?string $programStudyID;
  public ?string $submissionStatus;
  public ?string $lecturerID;

  public function __construct(Request $request)
  {
    $this->ID = $request->id;
    $this->name = $request->name;
    $this->username = $request->username;
    $this->classYear = $request->class_year;
    $this->programStudyID = $request->program_study_id;
    $this->submissionStatus = $request->submission_status;
    $this->lecturerID = $request->lecturer_id;
  }
}
