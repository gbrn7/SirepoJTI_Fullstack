<?php

namespace App\Services;

use App\Charts\ThesisTotalMaleFemalePieChart;
use App\Charts\ThesisTotalPerLecturerPieChart;
use App\Charts\ThesisTotalPerProdyHztBarChart;
use App\Charts\ThesisTotalPerTopicDonatChart;
use App\Charts\ThesisTotalPerTypeHztBarChart;
use App\Charts\ThesisTotalPerYearLineChart;
use App\Exports\StudentsExport;
use App\Models\Thesis;
use App\Support\Enums\SubmissionStatusEnum;
use App\Support\Interfaces\Repositories\LecturerRepositoryInterface;
use App\Support\Interfaces\Repositories\ProgramStudyRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisTopicRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisTypeRepositoryInterface;
use App\Support\Interfaces\Services\ThesisServiceInterface;
use App\Support\model\GetLecturerReqModel;
use App\Support\model\GetThesisReqModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class ThesisService implements ThesisServiceInterface
{
  public function __construct(
    protected ThesisRepositoryInterface $repository,
    protected ThesisTopicRepositoryInterface $ThesisTopicRepository,
    protected ThesisTypeRepositoryInterface $ThesisTypeRepository,
    protected LecturerRepositoryInterface $LecturerRepository,
    protected ProgramStudyRepositoryInterface $ProgramStudyRepository
  ) {}

  public function getThesis(GetThesisReqModel $reqModel, ?int $paginatePage = 5): Paginator|SupportCollection
  {
    return $this->repository->getThesis($reqModel, $paginatePage);
  }

  public function getDetailDocument(string $ID, bool|null $submissionStatus = null): ?Thesis
  {
    return $this->repository->getDetailDocument($ID, $submissionStatus);
  }

  public function downloadDocument(string $fileName): string|null
  {
    return Storage::get('document/' . $fileName);
  }

  public function storeThesis(string $studentID, array $data, UploadedFile|array|null $files)
  {
    try {
      $thesis = $this->repository->getThesisByStudentID($studentID);

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

      $data['student_id'] = $studentID;

      DB::beginTransaction();
      $this->repository->storeThesis($data, $newFiles->toArray());

      if (count($thesis) > 0) {
        $thesisIds = $thesis->pluck('id')->toArray();

        foreach ($thesis as $key => $value) {
          $files = $value->files;

          foreach ($files as $file) {
            // Delete old file
            Storage::delete('document/' . $file->file_name);
          }
        }

        $this->repository->destroyThesisByIDs($thesisIds);
      }

      DB::commit();
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  public function updateThesis(array $reqData, string $ID, UploadedFile|array|null $files)
  {
    try {

      $oldData = $this->repository->getThesisByID($ID);

      if (!isset($oldData)) throw new Exception('Tugas Akhir Tidak Ditemukan');

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

  public function updateThesisDownloadCount(string $ID): bool
  {
    try {
      $oldData = $this->repository->getThesisByID($ID);

      if (!isset($oldData)) throw new Exception('Tugas Akhir Tidak Ditemukan');
      $newData = ["download_count" => ($oldData->download_count + 1)];

      return $this->repository->updateThesis($oldData, $newData);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function processThesisFile(string $fileName, string $filePathName)
  {
    $logo = public_path("img/POLINEMA.png");

    $pdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);
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
    $pdf->SetProtection(array('copy', 'print-highres'));
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

  public function destroyThesisByID(string $ID): bool
  {
    $thesis = $this->repository->getThesisbyID($ID);

    if (!isset($thesis)) {
      throw new Error('Tugas Akhir Tidak Ditemukan');
    }

    $files = $thesis->files;

    foreach ($files as $file) {
      // Delete old file
      Storage::delete('document/' . $file->file_name);
    }

    return $this->repository->deleteThesis($thesis);
  }

  public function getThesisByID(string $ID): ?Thesis
  {
    return $this->repository->getThesisByID($ID);
  }

  public function bulkUpdateSubmissionStatus(array $IDs, string $status, ?string $note): bool
  {
    switch ($status) {
      case SubmissionStatusEnum::ACCEPTED->value:
        $status = true;
        $note = "";
        break;
      case SubmissionStatusEnum::DECLINED->value:
        $status = false;
        break;
      default:
        $status = null;
        break;
    }
    try {
      DB::beginTransaction();

      $result = $this->repository->bulkUpdateSubmissionStatus($IDs, $status, $note);

      DB::commit();
      return $result;
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  public function getThesisTotalPerYearLineChart(SupportCollection $data): LarapexChart
  {
    $years = [];

    for ($i = 0; $i < 5; $i++) {
      $years[] = Carbon::now()->subYears($i)->year;
    }

    $thesisPerYearRaw = $data->whereIn('publication_year', $years)->groupBy('publication_year')->map(function ($items) {
      return $items->count();
    });


    foreach ($years as $key) {
      if (!isset($thesisPerYearRaw[$key])) {
        $thesisPerYearRaw->put($key, 0);
      }
    }

    $thesisPerYear = collect();

    foreach ($thesisPerYearRaw as $key => $value) {
      $data = collect(['date' => $key, 'aggregate' => $value]);
      $thesisPerYear->push($data);
    }

    $thesisPerYear = $thesisPerYear->sortBy('date')->values();

    $chart = new LarapexChart;
    $barchart = new ThesisTotalPerYearLineChart($chart, $thesisPerYear);

    return $barchart->build();
  }


  public function getThesisTotalMaleFemalePieChart(SupportCollection $data): LarapexChart
  {
    $male = 0;
    $female = 0;
    foreach ($data as $item) {
      if ($item->gender == 'Male') {
        $male++;
      } else if ($item->gender == 'Female') {
        $female++;
      }
    }

    $dataTotal = collect(['male' => $male, 'female' => $female]);

    $chart = new LarapexChart;

    $pieChart = new ThesisTotalMaleFemalePieChart($chart, $dataTotal);

    return $pieChart->build();
  }

  public function getThesisTotalPerTopicDonatChart(SupportCollection $data): LarapexChart
  {
    $thesisTopicName = $this->ThesisTopicRepository->getThesisTopics()->pluck('topic');

    $thesisTotalPerTopicRaw = $data->groupBy('thesis_topic')->map(function ($items) {
      return $items->count();
    });

    $thesisTopic = collect();

    foreach ($thesisTopicName as $value) {
      $thesisTopic->push(collect(['label' => $value, 'value' => ($thesisTotalPerTopicRaw->get($value) ? $thesisTotalPerTopicRaw->get($value) : 0)]));
    }

    $thesisTopic = $thesisTopic->sortByDesc('value');

    $topThesisTopic = $thesisTopic->take(5);

    $otherThesisTopic = $thesisTopic->skip(5);

    $otherCount = $otherThesisTopic->sum('value');

    $topThesisTopic->push(collect(['label' => 'Lainnya', 'value' => $otherCount]));

    $chart = new LarapexChart;

    $topThesisTopic = $topThesisTopic->values();

    $pieChart = new ThesisTotalPerTopicDonatChart($chart, $topThesisTopic);

    return $pieChart->build();
  }

  public function getThesisTotalPerLecturerPieChart(SupportCollection $data): LarapexChart
  {
    $lecturerName = $this->LecturerRepository->getLecturers(new GetLecturerReqModel());

    $thesisTotalPerLecturerRaw = $data->groupBy('lecturer_id')->map(function ($items) {
      return $items->count();
    });

    $thesisLecturer = collect();

    foreach ($lecturerName as $value) {
      $thesisLecturer->push(collect(['label' => $value->name, 'value' => ($thesisTotalPerLecturerRaw->get($value->id) ? $thesisTotalPerLecturerRaw->get($value->id) : 0)]));
    }

    $thesisLecturer = $thesisLecturer->sortByDesc('value');

    $topLecturer = $thesisLecturer->take(5);

    if ($thesisLecturer->count() > 5) {
      $otherLecturer = $thesisLecturer->skip(5);
      $otherCount = $otherLecturer->sum('value');

      $topLecturer->push(collect(['label' => 'Lainnya', 'value' => $otherCount]));
    }

    $chart = new LarapexChart;

    $topLecturer = $topLecturer->values();

    $pieChart = new ThesisTotalPerLecturerPieChart($chart, $topLecturer);

    return $pieChart->build();
  }

  public function getThesisTotalPerProgramStudyHztBarChart(SupportCollection $data): LarapexChart
  {
    $programStudyName = $this->ProgramStudyRepository->getProgramStudys();

    $thesisTotalPerProgramStudyRaw = $data->groupBy('program_study_id')->map(function ($items) {
      return $items->count();
    });

    $thesisProgramStudy = collect();

    foreach ($programStudyName as $value) {
      $thesisProgramStudy->push(collect(['label' => $value->name, 'value' => ($thesisTotalPerProgramStudyRaw->get($value->id) ? $thesisTotalPerProgramStudyRaw->get($value->id) : 0)]));
    }

    $thesisProgramStudy = $thesisProgramStudy->sortByDesc('value');

    $topProgramStudy = $thesisProgramStudy->take(5);

    if ($thesisProgramStudy->count() > 5) {
      $otherProgramStudy = $thesisProgramStudy->skip(5);
      $otherCount = $otherProgramStudy->sum('value');

      $topProgramStudy->push(collect(['label' => 'Lainnya', 'value' => $otherCount]));
    }

    $chart = new LarapexChart;

    $topProgramStudy = $topProgramStudy->values();

    $barChar = new ThesisTotalPerProdyHztBarChart($chart, $topProgramStudy);

    return $barChar->build();
  }

  public function ThesisTotalPerTypeHztBarChart(SupportCollection $data): LarapexChart
  {
    $thesisTypeName = $this->ThesisTypeRepository->getThesisTypes();

    $thesisTotalPerThesisTypeRaw = $data->groupBy('thesis_type_id')->map(function ($items) {
      return $items->count();
    });

    $thesisType = collect();

    foreach ($thesisTypeName as $value) {
      $thesisType->push(collect(['label' => $value->type, 'value' => ($thesisTotalPerThesisTypeRaw->get($value->id) ? $thesisTotalPerThesisTypeRaw->get($value->id) : 0)]));
    }

    $thesisType = $thesisType->sortByDesc('value');

    $topThesisType = $thesisType->take(5);

    if ($thesisType->count() > 5) {
      $otherThesisType = $thesisType->skip(5);
      $otherCount = $otherThesisType->sum('value');

      $topThesisType->push(collect(['label' => 'Lainnya', 'value' => $otherCount]));
    }

    $chart = new LarapexChart;

    $topThesisType = $topThesisType->values();

    $barChar = new ThesisTotalPerTypeHztBarChart($chart, $topThesisType);

    return $barChar->build();
  }

  public function getThesisTotalPerClassYear(SupportCollection $data): SupportCollection
  {
    $thesisTotalPerClassYearRaw = $data->groupBy('class_year')->map(function ($items) {
      return $items->count();
    });

    $thesisTypePerClassYear = collect();

    foreach ($thesisTotalPerClassYearRaw as $key => $value) {
      $item = collect(['label' => $key, 'value' => $value]);
      $thesisTypePerClassYear->push($item);
    }

    $thesisTypePerClassYear = $thesisTypePerClassYear->sortByDesc('label');

    $TopThesisTypePerClassYear  = $thesisTypePerClassYear->take(5);

    if ($thesisTypePerClassYear->count() > 5) {
      $otherThesis = $thesisTypePerClassYear->skip(5);
      $otherCount = $otherThesis->sum('value');

      $TopThesisTypePerClassYear->push(collect(['label' => 'Lainnya', 'value' => $otherCount]));
    }

    return $TopThesisTypePerClassYear;
  }

  public function getThesisDownloadLeaderboard(SupportCollection $data): SupportCollection
  {
    $thesisDownloadLeaderboard = $data->sortByDesc('download_count')->take(5);

    return $thesisDownloadLeaderboard;
  }

  public function getThesisDashboard(GetThesisReqModel $reqModel)
  {
    $dashboardData = $this->repository->getThesisDashboardData($reqModel);

    $thesisTotalCount = $dashboardData->count();
    $thesisTotalPerYearBarChart = $this->getThesisTotalPerYearLineChart($dashboardData);
    $thesisTotalMaleFemale = $this->getThesisTotalMaleFemalePieChart($dashboardData);
    $thesisTotalPerTopic = $this->getThesisTotalPerTopicDonatChart($dashboardData);
    $thesisTotalPerLecturer = $this->getThesisTotalPerLecturerPieChart($dashboardData);
    $thesisTotalPerPrody = $this->getThesisTotalPerProgramStudyHztBarChart($dashboardData);
    $thesisTotalPerType = $this->ThesisTotalPerTypeHztBarChart($dashboardData);
    $thesisTotalPerClassYear = $this->getThesisTotalPerClassYear($dashboardData);
    $thesisDownloadLeaderboard = $this->getThesisDownloadLeaderboard($dashboardData);

    return [
      'thesisTotalCount' => $thesisTotalCount,
      'thesisTotalPerYearBarChart' => $thesisTotalPerYearBarChart,
      'thesisTotalMaleFemale' => $thesisTotalMaleFemale,
      'thesisTotalPerTopic' => $thesisTotalPerTopic,
      'thesisTotalPerLecturer' => $thesisTotalPerLecturer,
      'thesisTotalPerPrody' => $thesisTotalPerPrody,
      'thesisTotalPerType' => $thesisTotalPerType,
      'thesisTotalPerClassYear' => $thesisTotalPerClassYear,
      'thesisDownloadLeaderboard' => $thesisDownloadLeaderboard,
    ];
  }

  public function exportStudentsGuidanceData(Request $request, GetThesisReqModel $reqModel)
  {
    $documents = $this->getThesis($reqModel, null);

    $processedData = collect();
    foreach ($documents as $value) {
      $data = [
        "username" => $value->username,
        "name" => $value->first_name . " " . $value->last_name,
        "program_study" => $value->program_study_name,
      ];

      if (!isset($value->submission_status)) {
        $submissionStatus = 'Pending';
      } else {
        $submissionStatus = $value->submission_status ? "Diterima" : "Ditolak";
      }

      $data["submission_status"] = $submissionStatus;

      $processedData->push($data);
    }

    if ($request->export_format == 'excel') {
      return Excel::download(new StudentsExport($processedData), 'data-tugas-akhir-mahasiswa.xlsx');
    } else {
      $mpdf = new Mpdf();
      $mpdf->WriteHTML(view("pdf.students-data-export", ['students' => $processedData]));
      return $mpdf->Output('data-status-tugas-akhir-mhs.pdf', 'D');
    }
  }
}
