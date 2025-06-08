<?php

namespace App\Services;

use App\Models\Admin;
use App\Support\Interfaces\Repositories\AdminRepositoryInterface;
use App\Support\Interfaces\Services\AdminServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminService implements AdminServiceInterface
{
  public function __construct(
    protected AdminRepositoryInterface $repository
  ) {}

  public function getAdminByID(string $ID): ?Admin
  {
    return $this->repository->getAdminByID($ID);
  }

  public function updateAdmin(string $ID, array $reqData)
  {
    try {
      $oldData = $this->repository->getAdminByID($ID);

      if (!isset($oldData)) throw new Exception('Data Dosen Tidak Ditemukan');

      $arrayOldData = $oldData->toArray();
      $newData = collection::make();

      if (isset($reqData['old_password']) && isset($reqData['new_password'])) {
        if (!(Hash::check($reqData['old_password'], $oldData->password))) {
          throw new Exception('Password Lama Tidak Valid');
        } else {
          $newData->put('password', $reqData['new_password']);
        }
      }

      foreach ($arrayOldData as $key => $value) {
        if ($value != ($reqData[$key] ?? $value)) {
          $newData->put($key, $reqData[$key]);
        }
      }


      if (isset($newData['profile_picture'])) {
        // Store profile picture
        $file = $reqData['profile_picture'];

        $fileName = Str::random(10) . $file->getClientOriginalName();
        $file->storeAs('public/profile/', $fileName);

        $newData['profile_picture'] = $fileName;

        // Delete old file
        Storage::delete('public/profile/' . $oldData->profile_picture);
      }

      if (isset($reqData['password'])) {
        $newData['password'] = $reqData['password'];
      }

      return $this->repository->updateAdmin($oldData, $newData->toArray());
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
