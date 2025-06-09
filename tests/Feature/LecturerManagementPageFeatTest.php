<?php

use App\Models\Admin;
use App\Models\Lecturer;
use App\Models\ThesisTopic;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::beginTransaction();
    $this->admin = Admin::factory()->create();
    $this->admin->assignRole('admin');
});

test('Open lecturer management page', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('lecturer-management.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin_views.lecturer.index');
});

test('Open lecturer management page fails', function () {
    $response = $this->get(route('lecturer-management.index'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

test('Import lecturer data', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('lecturer-management.index'));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.lecturer.index');

    $topic = ThesisTopic::factory()->create();

    $file = new UploadedFile(
        base_path('tests/Fixtures/Template_Dosen.xlsx'), // or storage_path('app/test-files/sample.xlsx')
        'Template_Dosen.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true // marks it as a "test" file
    );

    $response = $this->post(route('importLecturerExcelData'), [
        "import_file" => $file,
        "topic_id" => $topic->id
    ]);

    $response->assertRedirect(route('lecturer-management.index'));
    $response->assertSessionHas('toast_success', 'Impor Berhasil');
});

test('Import lecturer fails', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('lecturer-management.index'));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.lecturer.index');

    $file = new UploadedFile(
        base_path('tests/Fixtures/Template_Dosen.xlsx'), // or storage_path('app/test-files/sample.xlsx')
        'Template_Dosen.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        null,
        true // marks it as a "test" file
    );

    $response = $this->post(route('importLecturerExcelData'), [
        "import_file" => $file,
        "topic_id" => fake()->word()
    ]);

    $response->assertRedirect(route('lecturer-management.index'));

    $response->assertSessionHas('toast_error', 'Gagal Menambahkan Data');
});

test('Open lecturer management create page', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('lecturer-management.create'));

    $response->assertStatus(200);
    $response->assertViewIs('admin_views.lecturer.lecturer_upsert_form');
});

test('Open lecturer management create page fails', function () {
    $response = $this->get(route('lecturer-management.create'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

test('Create lecturer data', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('lecturer-management.create'));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.lecturer.lecturer_upsert_form');

    $response = $this->post(route('lecturer-management.store'), [
        'topic_id' => ThesisTopic::inRandomOrder()->first()->id,
        'name' => fake()->name(),
        'username' => fake()->userName(),
        'email' => fake()->email(),
        'password' => 'lecturerpass',
    ]);

    $response->assertSessionHas('toast_success', "Data Dosen Ditambahkan");
    $response->assertRedirect(route('lecturer-management.index'));
});

test('Create lecturer data fails', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('lecturer-management.create'));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.lecturer.lecturer_upsert_form');

    $response = $this->post(route('lecturer-management.store'), [
        'topic_id' => ThesisTopic::inRandomOrder()->first()->id,
        'name' => fake()->name(),
        'username' => fake()->userName(),
        'email' => Lecturer::first()->email,
        'password' => 'lecturerpass'
    ]);

    $response->assertSessionHas('toast_error');
    $response->assertRedirect(route('lecturer-management.create'));
});

test('Update lecturer data', function () {
    $this->actingAs($this->admin);

    $lecturer = Lecturer::factory()->create();

    $response = $this->get(route('lecturer-management.edit', $lecturer->id));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.lecturer.lecturer_upsert_form');

    $response = $this->put(route('lecturer-management.update', $lecturer->id), [
        'topic_id' => ThesisTopic::inRandomOrder()->first()->id,
        'name' => fake()->name(),
        'username' => fake()->userName(),
        'email' => fake()->email(),
        'password' => 'lecturerpass'
    ]);

    $response->assertSessionHas('toast_success', "Data Dosen Diperbarui");
    $response->assertRedirect(route('lecturer-management.index'));
});

test('Update lecturer data fails get lecturer', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('lecturer-management.edit', fake()->word()));
    $response->assertStatus(302);
    $response->assertSessionHas('toast_error', 'Data Dosen Tidak Ditemukan');
});

test('Update lecturer data fails update', function () {
    $this->actingAs($this->admin);

    $lecturer = Lecturer::factory()->create();

    $response = $this->get(route('lecturer-management.edit', $lecturer->id));
    $response->assertStatus(200);
    $response->assertViewIs('admin_views.lecturer.lecturer_upsert_form');

    $response = $this->put(route('lecturer-management.update', $lecturer->id), [
        'topic_id' => ThesisTopic::inRandomOrder()->first()->id,
        'name' => fake()->name(),
        'username' => Lecturer::first()->username,
        'email' => fake()->email(),
        'password' => 'lecturerpass'
    ]);

    $response->assertSessionHas('toast_error', "Username Sudah Digunakan");
    $response->assertRedirect(route('lecturer-management.edit', $lecturer->id));
});

test('Delete lecturer data', function () {
    $this->actingAs($this->admin);

    $lecturer = Lecturer::factory()->create();

    $response = $this->delete(route('lecturer-management.destroy', $lecturer->id));

    $response->assertSessionHas('toast_success', "Data Dosen Dihapus");
    $response->assertRedirect(route('lecturer-management.index'));
});

test('Delete lecturer data fails', function () {
    $this->actingAs($this->admin);

    $response = $this->delete(route('lecturer-management.destroy', fake()->word()));

    $response->assertSessionHas('toast_error');
});

test('Show lecturer data', function () {
    $this->actingAs($this->admin);

    $lecturer = Lecturer::factory()->create();

    $response = $this->get(route('lecturer-management.show', $lecturer->id));

    $response->assertViewIs('admin_views.lecturer.lecturer_detail');
});

test('Show lecturer data fails', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('lecturer-management.show', fake()->word()));

    $response->assertSessionHas('toast_error', 'Data Dosen Tidak Ditemukan');
});

afterEach(function () {
    DB::rollBack();
});
