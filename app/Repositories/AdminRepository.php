<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Support\Interfaces\Repositories\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{

  public function getAdminByID(string $ID): ?Admin
  {
    return Admin::find($ID);
  }

  public function updateAdmin(Admin $admin, array $reqData)
  {
    return $admin->update($reqData);
  }
}
