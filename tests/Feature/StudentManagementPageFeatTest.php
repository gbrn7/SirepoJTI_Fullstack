<?php

use App\Models\Admin;
use App\Models\ProgramStudy;
use App\Models\Student;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::beginTransaction();
    $this->admin = Admin::factory()->create();
    $this->admin->assignRole('admin');
});

test('Open student management page', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('student-management.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin_views.student.index');
});

test('Open student management page fails', function () {
    $response = $this->get(route('student-management.index'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

test('Import student data', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('student-management.index'));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.student.index');

    $prody = ProgramStudy::factory()->create();

    $file = new UploadedFile(
        base_path('tests/Fixtures/Template_Mahasiswa.xlsx'), // or storage_path('app/test-files/sample.xlsx')
        'Template_Mahasiswa.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true // marks it as a "test" file
    );

    $response = $this->post(route('importStudentExcelData'), [
        "import_file" => $file,
        "program_study_id" => $prody->id
    ]);

    $response->assertRedirect(route('student-management.index'));
    $response->assertSessionHas('toast_success', 'Impor Berhasil');
});

test('Import student fails', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('student-management.index'));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.student.index');

    $prody = ProgramStudy::factory()->create();

    $file = new UploadedFile(
        base_path('tests/Fixtures/Template_Dosen.xlsx'), // or storage_path('app/test-files/sample.xlsx')
        'Template_Dosen.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true // marks it as a "test" file
    );

    $response = $this->post(route('importStudentExcelData'), [
        "import_file" => $file,
        "program_study_id" => $prody->id
    ]);

    $response->assertRedirect(route('student-management.index'));
    $response->assertSessionHas('toast_error', 'Gagal Menambahkan Data');
});

test('Open student management create page', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('student-management.create'));

    $response->assertStatus(200);
    $response->assertViewIs('admin_views.student.student_upsert_form');
});

test('Open student management create page fails', function () {
    $response = $this->get(route('student-management.create'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

test('Create student data', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('student-management.create'));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.student.student_upsert_form');

    $response = $this->post(route('student-management.store'), [
        "username" => fake()->userName(),
        'program_study_id' => ProgramStudy::inRandomOrder()->first()->id,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'gender' => fake()->randomElement(['Male', 'Female']),
        'class_year' => fake()->year(),
        'username' => fake()->userName(),
        'email' => fake()->email(),
        'password' => 'userpass',
    ]);

    $response->assertSessionHas('toast_success', "Data Mahasiswa Ditambahkan");
    $response->assertRedirect(route('student-management.index'));
});

test('Create student data fails', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('student-management.create'));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.student.student_upsert_form');

    $response = $this->post(route('student-management.store'), [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'gender' => fake()->randomElement(['Male', 'Female']),
        'class_year' => fake()->year(),
        'username' => fake()->userName(),
        'email' => fake()->email(),
        'password' => 'userpass',
    ]);

    $response->assertSessionHas('toast_error');
    $response->assertRedirect(route('student-management.create'));
});

test('Update student data', function () {
    $this->actingAs($this->admin);

    $student = Student::factory()->create();

    $response = $this->get(route('student-management.edit', $student->id));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.student.student_upsert_form');

    $response = $this->put(route('student-management.update', $student->id), [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'gender' => fake()->randomElement(['Male', 'Female']),
        'class_year' => fake()->year(),
        'username' => fake()->userName(),
        'email' => fake()->email(),
    ]);

    $response->assertSessionHas('toast_success', "Data Mahasiswa Diperbarui");
    $response->assertRedirect(route('student-management.index'));
});

test('Update student data fails get student', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('student-management.edit', fake()->word()));
    $response->assertStatus(302);
    $response->assertSessionHas('toast_error', 'Data Mahasiswa Tidak Ditemukan');
});

test('Update student data fails update', function () {
    $this->actingAs($this->admin);

    $student = Student::factory()->create();

    $response = $this->get(route('student-management.edit', $student->id));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.student.student_upsert_form');

    $response = $this->put(route('student-management.update', $student->id), [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'gender' => fake()->randomElement(['Male', 'Female']),
        'class_year' => fake()->year(),
        'username' => fake()->userName(),
        'email' => Student::first()->email,
    ]);

    $response->assertSessionHas('toast_error', "Email Sudah Digunakan");
    $response->assertRedirect(route('student-management.edit', $student->id));
});

test('Delete student data', function () {
    $this->actingAs($this->admin);

    $student = Student::factory()->create();

    $response = $this->delete(route('student-management.destroy', $student->id));

    $response->assertSessionHas('toast_success', "Data Mahasiswa Dihapus");
    $response->assertRedirect(route('student-management.index'));
});

test('Delete student data fails', function () {
    $this->actingAs($this->admin);

    $response = $this->delete(route('student-management.destroy', fake()->word()));

    $response->assertSessionHas('toast_error');
});

test('Show student data', function () {
    $this->actingAs($this->admin);

    $student = Student::factory()->create();

    $response = $this->get(route('student-management.show', $student->id));

    $response->assertViewIs('admin_views.student.student_detail');
});

test('Show student data fails', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('student-management.show', fake()->word()));

    $response->assertSessionHas('toast_error', 'Data Mahasiswa Tidak Ditemukan');
});

afterEach(function () {
    DB::rollBack();
});
