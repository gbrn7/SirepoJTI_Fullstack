<?php

use App\Models\ThesisType;
use App\Services\ThesisTypeService;
use App\Support\Interfaces\Repositories\ThesisTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

test('Get Thesis Type', function () {
    $ThesisType = ThesisType::factory()->count(10)->make();
    $ThesisTypeCollection = Collection::make($ThesisType);

    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypes')->andReturn($ThesisTypeCollection);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    expect($thesisService->getThesisTypes())->tobe($ThesisTypeCollection);
});

test('Get Thesis Type Fails', function () {
    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypes')->andThrow(Exception::class);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    $thesisService->getThesisTypes();
})->throws(Exception::class);

test('Store Thesis Type With Not Pass Type Name', function () {
    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $thesisService = new ThesisTypeService($thesisTypeMockRepo);

    $thesisService->storeThesisType([]);
})->throws(Exception::class, "Nama Jenis Tugas Akhir Wajib Disertakan");

test('Store Thesis Type', function () {
    $ThesisType = ThesisType::factory()->make();

    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByTypeName')->andReturn(null);
    $ThesisTypeMockRepo->shouldReceive('storeThesisType')->andReturn($ThesisType);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    expect($thesisService->storeThesisType(["type" => fake()->sentence()]))->tobe($ThesisType);
});

test('Store Thesis Type With Null Deleted At Thesis Type', function () {
    $thesisType = ThesisType::factory()->make();

    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $thesisTypeMockRepo->shouldReceive('getThesisTypeByTypeName')->andReturn($thesisType);

    $thesisService = new ThesisTypeService($thesisTypeMockRepo);

    expect($thesisService->storeThesisType(["type" => fake()->sentence()]))->tobe($thesisType);
})->throws(Exception::class, "Nama Jenis Tugas Akhir Telah Ditambahkan");

test('Store Thesis Type With Not Null Deleted At Thesis Type', function () {
    $thesisType = ThesisType::factory()->make([
        "deleted_at" => now()
    ]);

    $thesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $thesisTypeMockRepo->shouldReceive('getThesisTypeByTypeName')->andReturn($thesisType);
    $thesisTypeMockRepo->shouldReceive('updateThesisType')->andReturnTrue();

    $thesisService = new ThesisTypeService($thesisTypeMockRepo);

    expect($thesisService->storeThesisType(["type" => fake()->sentence()]))->tobe($thesisType);
});

test('Update Thesis Type', function () {
    $ThesisType = ThesisType::factory()->make();

    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByID')->andReturn($ThesisType);
    $ThesisTypeMockRepo->shouldReceive('updateThesisType')->andReturn(true);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    expect($thesisService->updateThesisType(fake()->randomNumber(), []))->toBeTrue();
});

test('Update Thesis Type Fails Get Thesis', function () {
    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByID')->andReturn(null);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    $thesisService->updateThesisType(fake()->randomNumber(), []);
})->throws(Exception::class, 'Data Jenis Tugas Akhir Tidak Ditemukan');

test('Update Thesis Type Error Get Thesis', function () {
    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByID')->andThrow(Exception::class);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    $thesisService->updateThesisType(fake()->randomNumber(), []);
})->throws(Exception::class);

test('Update Thesis Type Fails', function () {
    $ThesisType = ThesisType::factory()->make();

    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByID')->andReturn($ThesisType);
    $ThesisTypeMockRepo->shouldReceive('updateThesisType')->andThrow(Exception::class);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    $thesisService->updateThesisType(fake()->randomNumber(), []);
})->throws(Exception::class);

test('Delete Thesis Type', function () {
    $ThesisType = ThesisType::factory()->make();

    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByID')->andReturn($ThesisType);
    $ThesisTypeMockRepo->shouldReceive('deleteThesisType')->andReturn(true);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    expect($thesisService->deleteThesisType(fake()->randomNumber()))->toBeTrue();
});

test('Delete Thesis Type Fails Get Thesis', function () {
    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByID')->andReturn(null);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    $thesisService->deleteThesisType(fake()->randomNumber());
})->throws(Exception::class, 'Data Jenis Tugas Akhir Tidak Ditemukan');

test('Delete Thesis Type Error Get Thesis', function () {
    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByID')->andThrow(Exception::class);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    $thesisService->deleteThesisType(fake()->randomNumber());
})->throws(Exception::class);

test('Delete Thesis Type Fails', function () {
    $ThesisType = ThesisType::factory()->make();

    $ThesisTypeMockRepo = Mockery::mock(ThesisTypeRepositoryInterface::class);
    $ThesisTypeMockRepo->shouldReceive('getThesisTypeByID')->andThrow($ThesisType);
    $ThesisTypeMockRepo->shouldReceive('deleteThesisType')->andThrow(Exception::class);

    $thesisService = new ThesisTypeService($ThesisTypeMockRepo);

    $thesisService->deleteThesisType(fake()->randomNumber());
})->throws(Exception::class);
