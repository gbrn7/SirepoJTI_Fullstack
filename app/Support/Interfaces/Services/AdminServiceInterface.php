<?php

namespace App\Support\Interfaces\Services;

use App\Models\Admin;

interface AdminServiceInterface
{
  public function getAdminByID(string $ID): ?Admin;
  public function updateAdmin(string $ID, array $reqData);
}
