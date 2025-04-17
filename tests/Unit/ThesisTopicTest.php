<?php

use App\Models\ThesisTopic;
use App\Services\ThesisTopicService;
use App\Support\Interfaces\Repositories\ThesisTopicRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

test('Get Thesis Topics', function () {
    $thesisTopic = ThesisTopic::factory()->count(10)->make();
    $thesisTopicCollection = Collection::make($thesisTopic);

    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopics')->andReturn($thesisTopicCollection);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    expect($thesisService->getThesisTopics())->tobe($thesisTopicCollection);
});

test('Get Thesis Topics Fails', function () {
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopics')->andThrow(Exception::class);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    $thesisService->getThesisTopics();
})->throws(Exception::class);

test('Store Thesis Topic', function () {
    $thesisTopic = ThesisTopic::factory()->make();

    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('storeThesisTopic')->andReturn($thesisTopic);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    expect($thesisService->storeThesisTopic([]))->tobe($thesisTopic);
});

test('Store Thesis Topic Fails', function () {
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('storeThesisTopic')->andThrow(Exception::class);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    $thesisService->storeThesisTopic([]);
})->throws(Exception::class);

test('Update Thesis Topic', function () {
    $thesisTopic = ThesisTopic::factory()->make();

    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopicByID')->andReturn($thesisTopic);
    $thesisTopicMockRepo->shouldReceive('updateThesisTopic')->andReturn(true);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    expect($thesisService->updateThesisTopic(fake()->randomNumber(), []))->toBeTrue();
});

test('Update Thesis Topic Fails Get Thesis', function () {
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopicByID')->andReturn(null);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    $thesisService->updateThesisTopic(fake()->randomNumber(), []);
})->throws(Exception::class, 'Data Topik Tidak Ditemukan');

test('Update Thesis Topic Error Get Thesis', function () {
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopicByID')->andThrow(Exception::class);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    $thesisService->updateThesisTopic(fake()->randomNumber(), []);
})->throws(Exception::class);

test('Update Thesis Topic Fails', function () {
    $thesisTopic = ThesisTopic::factory()->make();

    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopicByID')->andReturn($thesisTopic);
    $thesisTopicMockRepo->shouldReceive('updateThesisTopic')->andThrow(Exception::class);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    $thesisService->updateThesisTopic(fake()->randomNumber(), []);
})->throws(Exception::class);

test('Delete Thesis Topic', function () {
    $thesisTopic = ThesisTopic::factory()->make();

    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopicByID')->andReturn($thesisTopic);
    $thesisTopicMockRepo->shouldReceive('deleteThesisTopic')->andReturn(true);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    expect($thesisService->deleteThesisTopic(fake()->randomNumber()))->toBeTrue();
});

test('Delete Thesis Topic Fails Get Thesis', function () {
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopicByID')->andReturn(null);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    $thesisService->deleteThesisTopic(fake()->randomNumber());
})->throws(Exception::class, 'Data Topik Tidak Ditemukan');

test('Delete Thesis Topic Error Get Thesis', function () {
    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopicByID')->andThrow(Exception::class);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    $thesisService->deleteThesisTopic(fake()->randomNumber());
})->throws(Exception::class);

test('Delete Thesis Topic Fails', function () {
    $thesisTopic = ThesisTopic::factory()->make();

    $thesisTopicMockRepo = Mockery::mock(ThesisTopicRepositoryInterface::class);
    $thesisTopicMockRepo->shouldReceive('getThesisTopicByID')->andThrow($thesisTopic);
    $thesisTopicMockRepo->shouldReceive('deleteThesisTopic')->andThrow(Exception::class);

    $thesisService = new ThesisTopicService($thesisTopicMockRepo);

    $thesisService->deleteThesisTopic(fake()->randomNumber());
})->throws(Exception::class);
