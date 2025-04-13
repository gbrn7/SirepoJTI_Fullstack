<?php

namespace App\Support\Interfaces\Repositories;

use App\Models\Admin;

interface AdminRepositoryInterface
{
  public function getAdminByID(string $ID): ?Admin;
  public function updateAdmin(Admin $admin, array $reqData);
}
