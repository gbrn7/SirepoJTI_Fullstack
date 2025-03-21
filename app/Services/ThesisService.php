<?php

namespace App\Services;

use App\Models\Thesis;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use App\Support\model\GetThesisReqModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class ThesisService implements ThesisServiceInterface
{
  public function __construct(
    protected ThesisRepositoryInterface $repository
  ) {}

  public function getThesis(GetThesisReqModel $reqModel): Paginator
  {
    return $this->repository->getThesis($reqModel);
  }

  public function getDetailDocument(string $ID, bool|null $submissionStatus = null): ?Thesis
  {
    return $this->repository->getDetailDocument($ID, $submissionStatus);
  }

  public function downloadDocument(string $fileName): string|null
  {
    return Storage::get('document/' . $fileName);
  }

  public function storeThesis(array $data, UploadedFile|array|null $files)
  {
    try {
      $newFiles = Collection::make();
      if (count($files) > 0) {
        $docIdentity = config('documentIdentity');

        foreach ($files as $key => $file) {
          $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

          $filePathName = $file->getPathName();

          $this->processThesisFile($fileName, $filePathName);

          $newFiles->push([
            "label" => $docIdentity[$key]['label'],
            "file_name" => $fileName,
            "sequence_num" => $docIdentity[$key]['sequence_num'],
          ]);
        }
      }

      $data['student_id'] = Auth::user()->id;

      DB::beginTransaction();
      $this->repository->storeThesis($data, $newFiles->toArray());

      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  public function updateThesis(array $reqData, string $ID, UploadedFile|array|null $files)
  {
    try {
      $oldData = Thesis::with('files')->find($ID);
      if (!$oldData) return redirect()->route('thesis-submission.index')->with('toast_error', 'Document Not Found');

      $arrayOldData = $oldData->toArray();
      $newData = collection::make();

      foreach ($arrayOldData as $key => $value) {
        if ($value != ($reqData[$key] ?? $value)) {
          $newData->put($key, $reqData[$key]);
        }
      }

      DB::beginTransaction();

      if (count($files) > 0) {
        $docIdentity = config('documentIdentity');

        foreach ($files as $key => $file) {
          $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

          $filePathName = $file->getPathName();

          $this->processThesisFile($fileName, $filePathName);

          // Delete old file
          Storage::delete('document/' . $oldData->file_name);

          // search params 
          $searchParams = ['sequence_num' => $docIdentity[$key]['sequence_num']];

          $newDataFiles = [
            'label' => $docIdentity[$key]['label'],
            'sequence_num' => $docIdentity[$key]['sequence_num'],
            'file_name' => $fileName,
          ];

          $this->repository->updateOrCreateThesisFile($oldData, $searchParams, $newDataFiles);
        }
      }

      $this->repository->updateThesis($oldData, $newData->toArray());

      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  public function processThesisFile(string $fileName, string $filePathName)
  {
    $logo = public_path("img/POLINEMA.png");

    $pdf = new Mpdf();
    $pagecount = $pdf->setSourceFile($filePathName);
    for ($i = 1; $i <= ($pagecount); $i++) {
      $pdf->AddPage();
      $import_page = $pdf->ImportPage($i);
      $pdf->UseTemplate($import_page);
      $pdf->SetWatermarkImage(
        $logo,
        0.1,
        '',
        'F'
      );
      $pdf->showWatermarkImage = true;
    }
    $pdf->SetProtection(array('copy', 'print'));
    $pdf->OutputFile(storage_path('app/document/' . $fileName));
  }


  public function getDetailDocumentByStudentID(string $studentID): ?Thesis
  {
    return $this->repository->getDetailDocumentByStudentID($studentID);
  }

  public function getYearFilters(): Collection
  {
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

  public function getThesisTypeFilters(): Collection
  {
    return $this->repository->getThesisTypeFilters();
  }

  public function getSuggestionThesisTitle(string $searcInput): Collection
  {
    return $this->repository->getSuggestionThesisTitle($searcInput);
  }
}
