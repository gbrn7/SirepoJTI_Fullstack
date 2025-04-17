<?php

use App\Models\Thesis;
use App\Services\ThesisService;
use App\Support\Enums\SubmissionStatusEnum;
use App\Support\Interfaces\Repositories\LecturerRepositoryInterface;
use App\Support\Interfaces\Repositories\ProgramStudyRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisTopicRepositoryInterface;
use App\Support\Interfaces\Repositories\ThesisTypeRepositoryInterface;
use App\Support\model\GetThesisReqModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Collection as SupportCollection;

test('Get Thesis', function () {
    $thesis = Thesis::factory()->count(10)->make();

    $paginator = new Paginator($thesis->toArray(), 2, 1);

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesis')->andReturn($paginator);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $request = Request::create('/fake-url', 'GET', []);

    $thesisReqModel = new GetThesisReqModel($request);

    expect($thesisService->getThesis($thesisReqModel))->tobe($paginator);
});

test('Get Thesis Fails', function () {
    $paginator = new Paginator([], 2, 1);

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesis')->andReturn($paginator);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $request = Request::create('/fake-url', 'GET', []);

    $thesisReqModel = new GetThesisReqModel($request);

    expect($thesisService->getThesis($thesisReqModel))->tobe($paginator);
});

test('Get Detail Document', function () {
    $thesis = Thesis::factory()->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getDetailDocument')->andReturn($thesis);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getDetailDocument(fake()->randomNumber(), null))->tobe($thesis);
});

test('Get Detail Document Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getDetailDocument')->andReturn(null);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getDetailDocument(fake()->randomNumber(), null))->toBeNull();
});

test('Download Document', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);


    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $fileName = 'testfile.txt';


    Storage::put('document/' . $fileName, 'Test file content');


    $file = Storage::get('document/' . $fileName);

    expect($thesisService->downloadDocument($fileName))->toBe($file);

    Storage::delete('document/' . $fileName);
});

test('Download Document Empty', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);


    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $fileName = fake()->Word(6) . '.txt';

    expect($thesisService->downloadDocument($fileName))->toBeNull();
});

test('Store Thesis', function () {
    $thesis = Thesis::factory()->make();

    $thesisCollection = Collection::make([]);

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisByStudentID')->andReturn($thesisCollection);

    $thesisMockRepo->shouldReceive('storeThesis')->andReturn($thesis);

    $data = [
        'topic_id' => fake()->randomNumber(),
        'type_id' => fake()->randomNumber(),
        'lecturer_id' => fake()->randomNumber(),
        'student_id' => fake()->randomNumber(),
        'title' => fake()->sentence(),
        'abstract' => fake()->text(),
        'download_count' => fake()->randomNumber(),
        'submission_status' => fake()->randomElement([null, 0, 1]),
        'note' => fake()->text(),
    ];

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->storeThesis(fake()->randomNumber(), $data, []))->toBeNull();
});

test('Store Thesis Fails', function () {
    $thesisCollection = Collection::make([]);

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisByStudentID')->andReturn($thesisCollection);

    $thesisMockRepo->shouldReceive('storeThesis')->andThrow(Exception::class);

    $data = [
        'topic_id' => fake()->randomNumber(),
        'type_id' => fake()->randomNumber(),
        'lecturer_id' => fake()->randomNumber(),
        'student_id' => fake()->randomNumber(),
        'title' => fake()->sentence(),
        'abstract' => fake()->text(),
        'download_count' => fake()->randomNumber(),
        'submission_status' => fake()->randomElement([null, 0, 1]),
        'note' => fake()->text(),
    ];

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->storeThesis(fake()->randomNumber(), $data, []);
})->throws(Exception::class);

test('Update Thesis', function () {
    $thesis = Thesis::factory()->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisByID')->andReturn($thesis);

    $thesisMockRepo->shouldReceive('updateThesis')->andReturn(null);

    $data = [
        'topic_id' => fake()->randomNumber(),
        'type_id' => fake()->randomNumber(),
        'lecturer_id' => fake()->randomNumber(),
        'student_id' => fake()->randomNumber(),
        'title' => fake()->sentence(),
        'abstract' => fake()->text(),
        'download_count' => fake()->randomNumber(),
        'submission_status' => fake()->randomElement([null, 0, 1]),
        'note' => fake()->text(),
    ];

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->updateThesis($data, fake()->randomNumber(), []))->toBeNull();
});

test('Update Thesis Fails Get Thesis', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisbyID')->andReturn(null);

    $data = [
        'topic_id' => fake()->randomNumber(),
        'type_id' => fake()->randomNumber(),
        'lecturer_id' => fake()->randomNumber(),
        'student_id' => fake()->randomNumber(),
        'title' => fake()->sentence(),
        'abstract' => fake()->text(),
        'download_count' => fake()->randomNumber(),
        'submission_status' => fake()->randomElement([null, 0, 1]),
        'note' => fake()->text(),
    ];

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->updateThesis($data, fake()->randomNumber(), []);
})->throws(Exception::class, 'Tugas Akhir Tidak Ditemukan');

test('Update Thesis Fails', function () {
    $thesis = Thesis::factory()->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisByID')->andReturn($thesis);

    $thesisMockRepo->shouldReceive('updateThesis')->andThrow(Exception::class);

    $data = [
        'topic_id' => fake()->randomNumber(),
        'type_id' => fake()->randomNumber(),
        'lecturer_id' => fake()->randomNumber(),
        'student_id' => fake()->randomNumber(),
        'title' => fake()->sentence(),
        'abstract' => fake()->text(),
        'download_count' => fake()->randomNumber(),
        'submission_status' => fake()->randomElement([null, 0, 1]),
        'note' => fake()->text(),
    ];

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->updateThesis($data, fake()->randomNumber(), []))->toBeNull();
})->throws(Exception::class);

test('Get Detail Document By Student ID', function () {
    $thesis = Thesis::factory()->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getDetailDocumentByStudentID')->andReturn($thesis);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getDetailDocumentByStudentID(fake()->randomNumber()))->toBe($thesis);
});

test('Get Detail Document By Student ID Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getDetailDocumentByStudentID')->andThrow(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->getDetailDocumentByStudentID(fake()->randomNumber());
})->throws(Exception::class);

test('Get Not Existed Detail Document By Student ID', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getDetailDocumentByStudentID')->andReturnNull();

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getDetailDocumentByStudentID(fake()->randomNumber()))->toBeNull();
});

test('Get Year Filters', function () {
    $thesis = Thesis::factory()->count(10)->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getYearFilters')->andReturn($thesis);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getYearFilters())->toBe($thesis);
});

test('Get Year Filters Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getYearFilters')->andThrow(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->getYearFilters();
})->throws(Exception::class);

test('Get Not Existed Year Filters', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getYearFilters')->andReturn(Collection::make([]));

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getYearFilters())->toBeInstanceOf(Collection::class);
});


test('Get Program Study Filter', function () {
    $thesis = Thesis::factory()->count(10)->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getProgramStudyFilters')->andReturn($thesis);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getProgramStudyFilters())->toBe($thesis);
});

test('Get Program Study Filters Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getProgramStudyFilters')->andThrow(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->getProgramStudyFilters();
})->throws(Exception::class);

test('Get Not Existed Program Study Filter', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getProgramStudyFilters')->andReturn(Collection::make([]));

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getProgramStudyFilters())->toBeInstanceOf(Collection::class);
});

test('Get Topic Filter', function () {
    $thesis = Thesis::factory()->count(10)->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getTopicFilters')->andReturn($thesis);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getTopicFilters())->toBe($thesis);
});

test('Get Topic Filters Filters Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getTopicFilters')->andThrow(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->getTopicFilters();
})->throws(Exception::class);

test('Get Not Existed Topic Filter', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getTopicFilters')->andReturn(Collection::make([]));

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getTopicFilters())->toBeInstanceOf(Collection::class);
});

test('Get Thesis Type', function () {
    $thesis = Thesis::factory()->count(10)->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisTypeFilters')->andReturn($thesis);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getThesisTypeFilters())->toBe($thesis);
});

test('Get Thesis Type Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisTypeFilters')->andThrow(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->getThesisTypeFilters();
})->throws(Exception::class);

test('Get Not Existed Thesis Type', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisTypeFilters')->andReturn(Collection::make([]));

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getThesisTypeFilters())->toBeInstanceOf(Collection::class);
});

test('Destroy Thesis BY ID', function () {
    $thesis = Thesis::factory()->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisbyID')->andReturn($thesis);

    $thesisMockRepo->shouldReceive('deleteThesis')->andReturnTrue();

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->destroyThesisByID(fake()->randomNumber()))->toBeTrue();
});

test('Destroy Empty Thesis BY ID', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisbyID')->andReturnNull();

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->destroyThesisByID(fake()->randomNumber());
})->throws(Error::class, 'Tugas akhir tidak ditemukan');

test('Destroy Thesis BY ID Fails', function () {
    $thesis = Thesis::factory()->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisbyID')->andReturn($thesis);
    $thesisMockRepo->shouldReceive('deleteThesis')->andThrows(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->destroyThesisByID(fake()->randomNumber());
})->throws(Exception::class);

test('Get Thesis BY ID', function () {
    $thesis = Thesis::factory()->make();

    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisbyID')->andReturn($thesis);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getThesisbyID(fake()->randomNumber()))->toBe($thesis);
});

test('Get Thesis BY ID Not Found', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisbyID')->andReturnNull();

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getThesisbyID(fake()->randomNumber()))->toBeNull();
});

test('Get Thesis BY ID Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('getThesisbyID')->andThrows(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->getThesisbyID(fake()->randomNumber());
})->throws(Exception::class);

test('Bulk Update Submission Status', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('bulkUpdateSubmissionStatus')->andReturnTrue();

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->bulkUpdateSubmissionStatus([fake()->randomNumber(), fake()->randomNumber()], SubmissionStatusEnum::ACCEPTED->value, ""))->toBeTrue();
});

test('Bulk Update Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisMockRepo->shouldReceive('bulkUpdateSubmissionStatus')->andThrows(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $thesisService->bulkUpdateSubmissionStatus([fake()->randomNumber(), fake()->randomNumber()], SubmissionStatusEnum::ACCEPTED->value, "");
})->throws(Exception::class);

test('Get Thesis Total Per Year Line Chart', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->getThesisTotalPerYearLineChart($data))->toBeInstanceOf(LarapexChart::class);
});

test('Get Thesis Male Female Pie Chart', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->getThesisTotalMaleFemalePieChart($data))->toBeInstanceOf(LarapexChart::class);
});

test('Get Thesis Total Per Topic Donat Chart', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisTopicMockRepo->shouldReceive('getThesisTopics')->andReturn(
        Collection::make(
            "Kecerdasan Buatan",
            "Sistem Informasi",
            "Data"
        )
    );

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->getThesisTotalPerTopicDonatChart($data))->toBeInstanceOf(LarapexChart::class);
});

test('Get Thesis Total Per Topic Donat Chart Fails', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisTopicMockRepo->shouldReceive('getThesisTopics')->andThrow(Exception::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->getThesisTotalPerTopicDonatChart($data))->toBeInstanceOf(LarapexChart::class);
})->throws(Exception::class);

test('Get Thesis Total Per Lecturer Pie Chart', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $lecturerMockRepo->shouldReceive('getLecturers')->andReturn(
        Collection::make(
            [
                (object)[
                    "id" => 1,
                    "topic_id" => 1,
                    "name" => "Usman Nur Hasan",
                    "username" => "usmannurhasan",
                    "email" => "usmen@gmail.com",
                    "password" => "userpass",
                    "created_at" => now(),
                    "updated_at" => now(),
                ]
            ]
        )
    );

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->getThesisTotalPerLecturerPieChart($data))->toBeInstanceOf(LarapexChart::class);
});

test('Get Thesis Total Per Prody Hzt Chart', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $ProgramStudyMockRepo->shouldReceive('getProgramStudys')->andReturn(
        Collection::make(
            [
                (object)[
                    'id' => 1,
                    'id_majority' => 1,
                    'name' => 'D2 Pengembangan Piranti Lunak Situs',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 2,
                    'id_majority' => 1,
                    'name' => 'D4 Teknik Informatika',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 3,
                    'id_majority' => 1,
                    'name' => 'D4 Sistem Informasi Bisnis',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 4,
                    'id_majority' => 1,
                    'name' => 'S2 Rekayasa Teknologi Informasi',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]
        )
    );

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->getThesisTotalPerProgramStudyHztBarChart($data))->toBeInstanceOf(LarapexChart::class);
});

test('Get Thesis Total Per Type Hzt Chart', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisTypeMockRepo->shouldReceive('getThesisTypes')->andReturn(
        Collection::make(
            [
                (object)[
                    'id' => 1,
                    'type' => 'Tugas Akhir',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 2,
                    'type' => 'Skripsi',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 3,
                    'type' => 'Tesis',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 4,
                    'type' => 'Desertasi',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]
        )
    );

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->ThesisTotalPerTypeHztBarChart($data))->toBeInstanceOf(LarapexChart::class);
});

test('Get Thesis Total Per Class Year', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->getThesisTotalPerClassYear($data))->toBeInstanceOf(SupportCollection::class);
});

test('Get Thesis Total Per Publication Year', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    expect($thesisService->getThesisTotalPerPublicationYear($data))->toBeInstanceOf(SupportCollection::class);
});

test('Get Thesis Dashbaord', function () {
    $thesisMockRepo = Mockery::mock(ThesisRepositoryInterface::class);
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $lecturerMockRepo = Mockery::mock(LecturerRepositoryInterface::class);
    $ProgramStudyMockRepo = Mockery::mock(ProgramStudyRepositoryInterface::class);

    $data = collect([
        (object)[
            "thesis_id" => 3,
            "student_id" => 4,
            "submission_status" => 1,
            "username" => "susipujiastuti",
            "program_study_id" => 4,
            "program_study_name" => "S2 Rekayasa Teknologi Informasi",
            "topic_id" => 3,
            "thesis_topic" => "Data",
            "publication_year" => 2024,
            "thesis_type_id" => 3,
            "thesis_type" => "Tesis",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Female",
        ],
        (object)[
            "thesis_id" => 2,
            "student_id" => 3,
            "submission_status" => 1,
            "username" => "bagustejo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 2,
            "thesis_topic" => "Sistem Informasi",
            "publication_year" => 2025,
            "thesis_type_id" => 2,
            "thesis_type" => "Skripsi",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
        (object)[
            "thesis_id" => 1,
            "student_id" => 1,
            "submission_status" => 1,
            "username" => "adesusilo",
            "program_study_id" => 3,
            "program_study_name" => "D4 Sistem Informasi Bisnis",
            "topic_id" => 1,
            "thesis_topic" => "Kecerdasan Buatan",
            "publication_year" => 2025,
            "thesis_type_id" => 1,
            "thesis_type" => "Tugas Akhir",
            "lecturer_id" => 1,
            "lecturer_name" => "Usman Nur Hasan",
            "class_year" => 2021,
            "gender" => "Male",
        ],
    ]);

    $thesisMockRepo->shouldReceive('getThesisDashboardData')->andReturn($data);
    $thesisTopicMockRepo->shouldReceive('getThesisTopics')->andReturn(
        Collection::make(
            "Kecerdasan Buatan",
            "Sistem Informasi",
            "Data"
        )
    );
    $lecturerMockRepo->shouldReceive('getLecturers')->andReturn(
        Collection::make(
            [
                (object)[
                    "id" => 1,
                    "topic_id" => 1,
                    "name" => "Usman Nur Hasan",
                    "username" => "usmannurhasan",
                    "email" => "usmen@gmail.com",
                    "password" => "userpass",
                    "created_at" => now(),
                    "updated_at" => now(),
                ]
            ]
        )
    );
    $ProgramStudyMockRepo->shouldReceive('getProgramStudys')->andReturn(
        Collection::make(
            [
                (object)[
                    'id' => 1,
                    'id_majority' => 1,
                    'name' => 'D2 Pengembangan Piranti Lunak Situs',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 2,
                    'id_majority' => 1,
                    'name' => 'D4 Teknik Informatika',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 3,
                    'id_majority' => 1,
                    'name' => 'D4 Sistem Informasi Bisnis',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 4,
                    'id_majority' => 1,
                    'name' => 'S2 Rekayasa Teknologi Informasi',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]
        )
    );
    $thesisTypeMockRepo->shouldReceive('getThesisTypes')->andReturn(
        Collection::make(
            [
                (object)[
                    'id' => 1,
                    'type' => 'Tugas Akhir',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 2,
                    'type' => 'Skripsi',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 3,
                    'type' => 'Tesis',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                (object)[
                    'id' => 4,
                    'type' => 'Desertasi',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]
        )
    );

    $request = Request::create('/fake-url', 'GET', []);

    $reqModel = new GetThesisReqModel($request);

    $thesisService = new ThesisService($thesisMockRepo, $thesisTopicMockRepo, $thesisTypeMockRepo, $lecturerMockRepo, $ProgramStudyMockRepo);

    expect($thesisService->getThesisDashboard($reqModel))->toBeArray();
});
