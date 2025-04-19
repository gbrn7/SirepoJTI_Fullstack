<?php

namespace App\Services;

use App\Models\ThesisType;
use App\Support\Interfaces\Repositories\ThesisTypeRepositoryInterface;
use App\Support\Interfaces\Services\ThesisTypeServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ThesisTypeService implements ThesisTypeServiceInterface
{
  public function __construct(
    protected ThesisTypeRepositoryInterface $repository
  ) {}

  public function getThesisTypes(): Collection
  {
    return $this->repository->getThesisTypes();
  }

  public function storeThesisType(array $data): ThesisType
  {
    try {
      if (!isset($data['type'])) throw new Exception("Data Jenis Tugas Akhir Wajib Disertakan");

      $thesisType = $this->repository->getThesisTypeByTypeName($data['type']);

      if (!$thesisType) {
        return $this->repository->storeThesisType($data);
      } else if (!$thesisType->deleted_at) {
        throw new Exception("Data Jenis Tugas Akhir Telah Ditambahkan");
      }

      $data = [
        "deleted_at" => null
      ];

      $this->repository->updateThesisType($thesisType, $data);

      return $thesisType;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function updateThesisType(string $ID, array $data): bool
  {
    try {
      $thesisType = $this->repository->getThesisTypeByID($ID);

      if (!isset($thesisType)) throw new Exception('Data Jenis Tugas Akhir Tidak Ditemukan');

      return  $this->repository->updateThesisType($thesisType, $data);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function deleteThesisType(string $ID): bool
  {
    try {
      $thesisType = $this->repository->getThesisTypeByID($ID);

      if (!isset($thesisType)) throw new Exception('Data Jenis Tugas Akhir Tidak Ditemukan');

      return  $this->repository->deleteThesisType($thesisType);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
