<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Services\StudentService;
use App\Support\Interfaces\Repositories\StudentRepositoryInterface;
use App\Support\model\GetStudentReqModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;

class StudentServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_students(): void
    {
        $students = Student::factory()->count(10)->make();

        $paginator = new Paginator($students->toArray(), 2, 1);

        $randStudent = $students->random();

        $dataRequest = [
            'first_name' => $randStudent->first_name,
            'last_name' => $randStudent->first_name,
            'email' => $randStudent->email,
        ];

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) use ($paginator) {
            $mock->shouldReceive('getStudents')->andReturn($paginator);
        });

        $request = Request::create('/fake-url', 'GET', $dataRequest);

        $reqModel = new GetStudentReqModel($request);

        $studentService = new StudentService($studentRepository);

        $this->assertSame($paginator, $studentService->getStudents($reqModel));
    }

    public function test_get_students_fails(): void
    {
        $paginator = new Paginator([], 10, 1);

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) use ($paginator) {
            $mock->shouldReceive('getStudents')->andReturn($paginator);
        });

        $request = Request::create('/fake-url', 'GET', []);

        $reqModel = new GetStudentReqModel($request);

        $studentService = new StudentService($studentRepository);

        $this->assertSame($paginator, $studentService->getStudents($reqModel));
    }

    public function test_get_suggestion_author(): void
    {
        $students = Student::factory()->count(10)->make();

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) use ($students) {
            $mock->shouldReceive('getSuggestionAuthor')->andReturn($students);
        });
        $studentService = new StudentService($studentRepository);

        $this->assertSame($students, $studentService->getSuggestionAuthor(fake()->name()));
    }

    public function test_get_suggestion_author_fails(): void
    {
        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getSuggestionAuthor')->andReturn(Collection::make([]));
        });
        $studentService = new StudentService($studentRepository);

        $this->assertInstanceOf(Collection::class, $studentService->getSuggestionAuthor(fake()->name()));
    }

    public function test_get_author_filter(): void
    {
        $students = Student::factory()->count(10)->make();

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) use ($students) {
            $mock->shouldReceive('getSuggestionAuthor')->andReturn($students);
        });
        $studentService = new StudentService($studentRepository);

        $this->assertSame($students, $studentService->getSuggestionAuthor(fake()->word()));
    }

    public function test_get_author_filter_fails(): void
    {

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getSuggestionAuthor')->andReturn(Collection::make());
        });
        $studentService = new StudentService($studentRepository);

        $this->assertInstanceOf(Collection::class, $studentService->getSuggestionAuthor(fake()->word()));
    }

    public function test_get_student_by_username(): void
    {
        $student = Student::factory()->make();

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) use ($student) {
            $mock->shouldReceive('getStudentByUsername')->andReturn($student);
        });
        $studentService = new StudentService($studentRepository);

        $this->assertSame($student, $studentService->getStudentByUsername(fake()->username()));
    }

    public function test_get_student_by_username_fails(): void
    {

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('getStudentByUsername')->andReturn(null);
        });
        $studentService = new StudentService($studentRepository);

        $this->assertNull($studentService->getStudentByUsername(fake()->username()));
    }

    public function test_store_student(): void
    {
        $student = Student::factory()->make();

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) use ($student) {
            $mock->shouldReceive('storeStudent')->andReturn($student);
        });
        $studentService = new StudentService($studentRepository);

        $reqData = [
            'program_study_id' => $student->program_study_id,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'gender' => $student->gender,
            'class_year' => $student->class_year,
            'username' => $student->username,
            'email' => $student->email,
            'password' => 'test',
        ];


        $this->assertNull($studentService->storeStudent($reqData));
    }

    public function test_store_student_fails(): void
    {

        $studentRepository = Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('storeStudent')->andThrow(new Exception());
        });
        $studentService = new StudentService($studentRepository);

        $this->expectException(Exception::class);

        $studentService->storeStudent([]);
    }

    public function test_update_student(): void
    {
        $student = Student::factory()->make();

        $studentMockRepo = Mockery::mock(StudentRepositoryInterface::class);
        $studentMockRepo->shouldReceive('getStudentByID')->andReturn($student);
        $studentMockRepo->shouldReceive('updateStudent')->andReturn(true);

        $studentService = new StudentService($studentMockRepo);

        $reqData = [
            'program_study_id' => fake()->randomNumber(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'class_year' => fake()->year(),
        ];


        $this->assertNull($studentService->updateStudent(fake()->randomNumber, $reqData));
    }

    public function test_update_student_fails_get_student(): void
    {

        $studentMockRepo = Mockery::mock(StudentRepositoryInterface::class);
        $studentMockRepo->shouldReceive('getStudentByID')->andReturn(null);

        $studentService = new StudentService($studentMockRepo);

        $reqData = [
            'program_study_id' => fake()->randomNumber(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'class_year' => fake()->year(),
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Data Mahasiswa Tidak Ditemukan');

        $studentService->updateStudent(fake()->randomNumber, $reqData);
    }

    public function test_update_student_fails(): void
    {
        $student = Student::factory()->make();

        $studentMockRepo = Mockery::mock(StudentRepositoryInterface::class);
        $studentMockRepo->shouldReceive('getStudentByID')->andReturn($student);
        $studentMockRepo->shouldReceive('updateStudent')->andThrow(new Exception);

        $studentService = new StudentService($studentMockRepo);

        $reqData = [
            'program_study_id' => fake()->randomNumber(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'class_year' => fake()->year(),
        ];


        $this->expectException(Exception::class);

        $studentService->updateStudent(fake()->randomNumber, $reqData);
    }

    public function test_delete_student(): void
    {
        $student = Student::factory()->make();

        $studentMockRepo = Mockery::mock(StudentRepositoryInterface::class);
        $studentMockRepo->shouldReceive('deleteStudent')->andReturn($student);

        $studentService = new StudentService($studentMockRepo);

        $this->assertNull($studentService->deleteStudent(fake()->randomNumber()));
    }

    public function test_delete_student_fails(): void
    {
        $studentMockRepo = Mockery::mock(StudentRepositoryInterface::class);
        $studentMockRepo->shouldReceive('deleteStudent')->andThrow(Exception::class);

        $studentService = new StudentService($studentMockRepo);

        $this->expectException(Exception::class);

        $studentService->deleteStudent(fake()->randomNumber());
    }

    public function test_import_excel(): void
    {
        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([
                [
                    [
                        'first_name' => fake()->firstName(),
                        'nama' => fake()->firstName(),
                        'jenis_kelamin_malefemale' => fake()->randomElement(['male', 'female']),
                        'tahun_angkatan' => fake()->year(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                    ],
                    [
                        'nama' => fake()->firstName(),
                        'jenis_kelamin_malefemale' => fake()->randomElement(['male', 'female']),
                        'tahun_angkatan' => fake()->year(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                    ],
                    [
                        'nama' => fake()->firstName(),
                        'jenis_kelamin_malefemale' => fake()->randomElement(['male', 'female']),
                        'tahun_angkatan' => fake()->year(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                    ],
                ]
            ]);

        $studentRepository = \Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('insertStudents')->andReturn(true);
        });

        $studentService = new StudentService($studentRepository);

        $fakeFile = UploadedFile::fake()->image('template.excel');

        $this->assertNull($studentService->importExcel(fake()->randomNumber(), $fakeFile));
    }

    public function test_import_excel_fails_import(): void
    {
        Excel::shouldReceive('toArray')
            ->once()
            ->andThrow(Exception::class);

        $studentRepository = \Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('insertStudents')->andReturn(true);
        });

        $studentService = new StudentService($studentRepository);

        $fakeFile = UploadedFile::fake()->image('template.excel');

        $this->expectException(Exception::class);

        $studentService->importExcel(fake()->randomNumber(), $fakeFile);
    }

    public function test_import_excel_fails_insert(): void
    {
        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([
                [
                    [
                        'first_name' => fake()->firstName(),
                        'nama' => fake()->firstName(),
                        'jenis_kelamin_malefemale' => fake()->randomElement(['male', 'female']),
                        'tahun_angkatan' => fake()->year(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                    ],
                    [
                        'nama' => fake()->firstName(),
                        'jenis_kelamin_malefemale' => fake()->randomElement(['male', 'female']),
                        'tahun_angkatan' => fake()->year(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                    ],
                    [
                        'nama' => fake()->firstName(),
                        'jenis_kelamin_malefemale' => fake()->randomElement(['male', 'female']),
                        'tahun_angkatan' => fake()->year(),
                        'username' => fake()->userName(),
                        'email' => fake()->email(),
                        'password' => fake()->password(),
                    ],
                ]
            ]);

        $studentRepository = \Mockery::mock(StudentRepositoryInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('insertStudents')->andThrow(Exception::class);
        });

        $studentService = new StudentService($studentRepository);

        $fakeFile = UploadedFile::fake()->image('template.excel');

        $this->expectException(Exception::class);

        $studentService->importExcel(fake()->randomNumber(), $fakeFile);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
