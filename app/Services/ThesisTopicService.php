<?php

namespace App\Services;

use App\Models\ThesisTopic;
use App\Support\Interfaces\Repositories\ThesisTopicRepositoryInterface;
use App\Support\Interfaces\Services\ThesisTopicServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ThesisTopicService implements ThesisTopicServiceInterface
{
  public function __construct(
    protected ThesisTopicRepositoryInterface $repository
  ) {}

  public function getThesisTopics(): Collection
  {
    return $this->repository->getThesisTopics();
  }

  public function storeThesisTopic(array $data): ThesisTopic
  {
    try {
      if (!isset($data['topic'])) throw new Exception("Nama Topik Tugas Akhir Wajib Disertakan");

      $thesisTopic = $this->repository->getThesisTopicByTopicName($data['topic']);

      if (!$thesisTopic) {
        return $this->repository->storeThesisTopic($data);
      } else if (!$thesisTopic->deleted_at) {
        throw new Exception("Nama Topik Tugas Akhir Telah Ditambahkan");
      }

      $data = [
        "deleted_at" => null
      ];

      $this->repository->updateThesisTopic($thesisTopic, $data);

      return $thesisTopic;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function updateThesisTopic(string $ID, array $data): bool
  {
    try {
      $thesisTopic = $this->repository->getThesisTopicByID($ID);

      if (!isset($thesisTopic)) throw new Exception('Data Topik Tugas Akhir Tidak Ditemukan');

      return  $this->repository->updateThesisTopic($thesisTopic, $data);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function deleteThesisTopic(string $ID): bool
  {
    try {
      $thesisTopic = $this->repository->getThesisTopicByID($ID);

      if (!isset($thesisTopic)) throw new Exception('Data Topik Tugas Akhir Tidak Ditemukan');

      return  $this->repository->deleteThesisTopic($thesisTopic);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
