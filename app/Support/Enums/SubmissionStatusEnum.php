<?php

namespace App\Support\Enums;

enum SubmissionStatusEnum: string
{
  case ACCEPTED = 'accepted';
  case DECLINED = 'declined';
  case PENDING = 'pending';
}
