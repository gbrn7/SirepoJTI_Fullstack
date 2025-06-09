<?php

namespace Tests\Unit;

use App\Models\Lecturer;
use App\Repositories\LecturerRepository;
use App\Services\LecturerService;
use App\Support\Interfaces\Repositories\LecturerRepositoryInterface;
use App\Support\model\GetLecturerReqModel;
use Exception;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mockery;
use Illuminate\Http\UploadedFile;

class LecturerServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_lecturers_without_request_model(): void
    {
        $lecturer = Lecturer::factory()->count(15)->make();

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) use ($lecturer) {
            $mock->shouldReceive('getLecturers')->andReturn($lecturer);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->assertSame($lecturer, $lecturerService->getLecturers(null, false));
    }

    public function test_get_lecturers_with_request_model(): void
    {
        $lecturer = Lecturer::factory()->count(15)->make();

        $dataRequest = [
            'name' => $lecturer->random()->name,
        ];

        $lecturerData = $lecturer->where('name', $dataRequest['name']);

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) use ($lecturerData) {

            $mock->shouldReceive('getLecturers')->andReturn($lecturerData);
        });

        $request = Request::create('/fake-url', 'GET', $dataRequest);

        $reqModel = new GetLecturerReqModel($request);

        $lecturerService = new LecturerService($lecturerRepository);

        $this->assertSame($lecturerData, $lecturerService->getLecturers($reqModel, false));
    }

    public function test_store_lecturer(): void
    {
        $dataRequest = [
            'name' => 'test',
            'username' => 'testusername',
            'email' => 'testemail',
            'password' => 'testpassword',
            "topic_id" => 1,

        ];

        $lecturer = Lecturer::factory()->make($dataRequest);

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) use ($lecturer) {
            $mock->shouldReceive('storeLecturer')->andReturn($lecturer);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->assertSame($lecturer, $lecturerService->storeLecturer($dataRequest));
    }

    public function test_store_lecturer_fails(): void
    {
        $dataRequest = [
            'name' => 'test',
            'username' => 'testusername',
            'email' => 'testemail',
            'password' => 'testpassword',
            "topic_id" => 1,

        ];

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('storeLecturer')->andThrow(new Exception("failed"));
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->expectException(Exception::class);
        $lecturerService->storeLecturer($dataRequest);
    }

    public function test_get_lecturer_by_id(): void
    {
        $lecturer = Lecturer::factory()->make();

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) use ($lecturer) {
            $mock->shouldReceive('getLecturerByID')->andReturn($lecturer);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->assertSame($lecturer, $lecturerService->getLecturerByID((string)$lecturer->id));
    }

    public function test_get_lecturer_by_id_fails(): void
    {
        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getLecturerByID')->andReturn(null);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->assertNull($lecturerService->getLecturerByID('test'));
    }

    public function test_update_lecturer(): void
    {
        $lecturer = Lecturer::factory()->make();

        $newData = [
            'name' => "test_update",
            'nip' => "test_username"
        ];

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) use ($lecturer) {
            $mock->shouldReceive('getLecturerByID')->andReturn($lecturer);

            $mock->shouldReceive('updateLecturer')->andReturn(true);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->assertTrue($lecturerService->updateLecturer("1", $newData));
    }

    public function test_update_lecturer_fail_get_lecturer(): void
    {

        $newData = [
            'name' => "test_update",
            'username' => "test_username"
        ];

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getLecturerByID')->andReturn(null);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Data Dosen Tidak Ditemukan');

        $lecturerService->updateLecturer("1", $newData);
    }

    public function test_update_lecturer_fails_update(): void
    {
        $lecturer = Lecturer::factory()->make();

        $newData = [
            'name' => "test_update",
            'username' => "test_username"
        ];

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) use ($lecturer) {
            $mock->shouldReceive('getLecturerByID')->andReturn($lecturer);

            $mock->shouldReceive('updateLecturer')->andThrow(Exception::class);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->expectException(Exception::class);

        $lecturerService->updateLecturer("1", $newData);
    }

    public function test_delete_lecturer(): void
    {
        $lecturer = Lecturer::factory()->make();

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) use ($lecturer) {
            $mock->shouldReceive('deleteLecturer')->andReturn($lecturer);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->assertSame($lecturer, $lecturerService->deleteLecturer("1"));
    }

    public function test_delete_lecturer_fails(): void
    {

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('deleteLecturer')->andThrow(new Exception('Data Dosen Tidak Ditemukan'));
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Data Dosen Tidak Ditemukan');

        $lecturerService->deleteLecturer("1");
    }

    public function test_import_excel(): void
    {
        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([
                [
                    [
                        'nama' => 'test',
                        'nip' => 'testusername',
                        'email' => 'testemail@test.com',
                        'password' => 'testpassword',
                    ],
                    [
                        'nama' => 'test',
                        'nip' => 'testusername',
                        'email' => 'testemail@test.com',
                        'password' => 'testpassword',
                    ],
                    [
                        'nama' => 'test',
                        'nip' => 'testusername',
                        'email' => 'testemail@test.com',
                        'password' => 'testpassword',
                    ],
                ]
            ]);

        $lecturerRepository = \Mockery::mock(LecturerRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('insertLecturers')->andReturn(true);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $fakeFile = UploadedFile::fake()->image('template.excel');

        $this->assertNull($lecturerService->importExcel("1", $fakeFile));
    }

    public function test_import_excel_fails_import(): void
    {
        Excel::shouldReceive('toArray')
            ->once()
            ->andThrow(Exception::class);

        $lecturerRepository = \Mockery::mock(LecturerRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('insertLecturers')->andReturn(true);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $fakeFile = UploadedFile::fake()->image('template.excel');

        $this->expectException(Exception::class);

        $lecturerService->importExcel(fake()->randomNumber(), $fakeFile);
    }

    public function test_import_excel_fails_insert(): void
    {
        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([
                [
                    [
                        'nama' => fake()->name(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'nama' => fake()->name(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'nama' => fake()->name(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]
            ]);

        $lecturerRepository = \Mockery::mock(LecturerRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('insertLecturers')->andThrow(Exception::class);
        });

        $lecturerService = new LecturerService($lecturerRepository);

        $fakeFile = UploadedFile::fake()->image('template.excel');

        $this->expectException(Exception::class);

        $lecturerService->importExcel(fake()->randomNumber(), $fakeFile);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
