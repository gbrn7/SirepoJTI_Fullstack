<?php

namespace Tests\Unit;

use App\Models\ProgramStudy;
use App\Repositories\ProgramStudyRepository;
use App\Services\ProgramStudyService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ProgramStudyTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_program_studys(): void
    {
        $programStudys = ProgramStudy::factory()->count(10)->make();

        $prodyRepository = Mockery::mock(ProgramStudyRepository::class, function (MockInterface $mock) use ($programStudys) {
            $mock->shouldReceive('getProgramStudys')->andReturn($programStudys);
        });

        $prodyService = new ProgramStudyService($prodyRepository);

        $this->assertSame($programStudys, $prodyService->getProgramStudys());
    }

    public function test_get_program_studys_null(): void
    {
        $prodyRepository = Mockery::mock(ProgramStudyRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getProgramStudys')->andReturn(Collection::make());
        });

        $prodyService = new ProgramStudyService($prodyRepository);

        $this->assertInstanceOf(Collection::class, $prodyService->getProgramStudys());
    }
}
