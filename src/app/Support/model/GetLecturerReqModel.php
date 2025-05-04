<?php

namespace App\Support\model;

use Illuminate\Http\Request;

class GetLecturerReqModel
{
  public ?string $ID;
  public ?string $name;
  public ?string $username;
  public ?string $email;

  public function __construct(?Request $request = null)
  {
    $this->ID = $request?->id;
    $this->name = $request?->name;
    $this->username = $request?->username;
    $this->email = $request?->email;
  }
}
