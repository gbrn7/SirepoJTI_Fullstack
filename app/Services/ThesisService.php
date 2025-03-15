<?php

namespace App\Services;

use App\Models\Thesis;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ThesisService implements ThesisServiceInterface
{
  public function __construct(
    protected ThesisRepositoryInterface $repository
  ) {}

  public function getThesis(GetThesisReqModel $reqModel): Paginator
  {
    return $this->repository->getThesis($reqModel);
  }

  public function getDetailDocument(string $ID): Thesis | null
  {
    return $this->repository->getDetailDocumentForStudent($ID);
  }

  public function downloadDocument(string $fileName): string|null
  {
    return Storage::get('document/' . $fileName);
  }

  public function getYearFilters(): Collection
  {
    // Download PDF
    // return Storage::download('public/Document/'.$fileName);
    return $this->repository->getYearFilters();
  }

  public function getProgramStudyFilters(): Collection
  {
    return $this->repository->getProgramStudyFilters();
  }

  public function getTopicFilters(): Collection
  {
    return $this->repository->getTopicFilters();
  }

  public function getAuthorFilters(?string $alphabet = "A"): Collection
  {
    return $this->repository->getAuthorFilters($alphabet ? $alphabet : "A");
  }

  public function getThesisTypeFilters(): Collection
  {
    return $this->repository->getThesisTypeFilters();
  }

  public function getSuggestionThesisTitle(string $searcInput): Collection
  {
    return $this->repository->getSuggestionThesisTitle($searcInput);
  }
}
