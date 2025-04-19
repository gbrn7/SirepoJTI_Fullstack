<?php

use App\Models\Admin;
use App\Models\ThesisType;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::beginTransaction();
    $this->admin = Admin::factory()->create();
    $this->admin->assignRole('admin');
});

test('Open thesis type management page', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('thesis-type-management.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin_views.thesis-type.index');
});

test('Open thesis type management page fails', function () {
    $response = $this->get(route('thesis-type-management.index'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

test('Create thesis type data', function () {
    $this->actingAs($this->admin);

    $response = $this->post(route('thesis-type-management.store'), [
        'type' => fake()->sentence(),
    ]);

    $response->assertSessionHas('toast_success', "Data Jenis Tugas Akhir Ditambahkan");
});

test('Create thesis type data fails', function () {
    $this->actingAs($this->admin);

    $response = $this->post(route('thesis-type-management.store'), []);

    $response->assertSessionHas('toast_error', "Data Jenis Tugas Akhir Wajib Diisi");
});

test('Update thesis type data', function () {
    $this->actingAs($this->admin);

    $thesisType = ThesisType::factory()->create();

    $response = $this->put(route('thesis-type-management.update', $thesisType->id), [
        'type' => fake()->sentence(),
    ]);

    $response->assertSessionHas('toast_success', "Data Jenis Tugas Akhir Diperbarui");
});

test('Update thesis type data fails get thesis type', function () {
    $this->actingAs($this->admin);

    $response = $this->put(route('thesis-type-management.update', fake()->word()), [
        'type' => fake()->sentence(),
    ]);

    $response->assertStatus(302);
    $response->assertSessionHas('toast_error', 'Gagal Memperbarui Data Jenis Tugas Akhir');
});

test('Delete thesis type data', function () {
    $this->actingAs($this->admin);

    $thesisType = ThesisType::factory()->create();

    $response = $this->delete(route('thesis-type-management.destroy', $thesisType->id));

    $response->assertSessionHas('toast_success', "Data Jenis Tugas Akhir Dihapus");
});

test('Delete thesis Type data fails', function () {
    $this->actingAs($this->admin);

    $response = $this->delete(route('thesis-type-management.destroy', fake()->word()));

    $response->assertSessionHas('toast_error', 'Gagal Menghapus Data Jenis Tugas Akhir');
});

afterEach(function () {
    DB::rollBack();
});
