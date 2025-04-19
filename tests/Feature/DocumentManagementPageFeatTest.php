<?php

use App\Models\Admin;
use App\Models\Student;
use App\Models\Thesis;
use App\Support\Enums\SubmissionStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::beginTransaction();
    $this->admin = Admin::factory()->create();
    $this->admin->assignRole('admin');
});

test('Open document management', function () {
    $this->actingAs($this->admin, 'admin');

    $response = $this->get(route('document-management.index'));

    $response->assertStatus(200);
});

test('Open document management by guest user', function () {
    $response = $this->get(route('document-management.index'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

test('Open document management create', function () {
    $this->actingAs($this->admin, 'admin');

    $response = $this->get(route('document-management.create'));

    $response->assertOK();
});

test('Open document management create fails', function () {
    Auth::logout();
    $response = $this->get(route('document-management.create'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

test('Edit document', function () {
    $thesis = Thesis::factory()->create();

    $this->actingAs($this->admin);
    $response = $this->get(route('document-management.edit', $thesis->id));
    $response->assertOK();

    $response = $this->put(route('document-management.update', $thesis->id), [
        "title" => fake()->sentence(),
        "abstract" => fake()->text(),
    ]);

    $response->assertSessionHas('toast_success', "Tugas Akhir Diperbarui");
    $response->assertRedirect(route('document-management.index'));
});

test('Edit document fails get document', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('document-management.edit', fake()->word()));

    $response->assertStatus(302);
    $response->assertSessionHas('toast_error', "Tugas Akhir Tidak Ditemukan");
});

test('Delete document', function () {
    $thesis = Thesis::factory()->create();

    $this->actingAs($this->admin);
    $response = $this->get(route('document-management.index'));
    $response->assertOK();

    $response = $this->delete(route('document-management.destroy', $thesis->id));

    $response->assertSessionHas('toast_success', "Data Tugas Akhir Dihapus");
    $response->assertRedirect(route('document-management.index'));
});

test('Delete document fails get document', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('document-management.index'));
    $response->assertOK();

    $response = $this->delete(route('document-management.destroy', fake()->word()));

    $response->assertSessionHas('toast_error', "Tugas Akhir Tidak Ditemukan");
});

test('Show document', function () {
    $this->actingAs($this->admin);

    $thesis = Thesis::factory()->create();

    $response = $this->get(route('document-management.show', $thesis->id));

    $response->assertStatus(200);
    $response->assertViewIs('admin_views.document.detail_document');
});

test('Show document fails', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('document-management.show', fake()->word()));

    $response->assertStatus(302);
    $response->assertSessionHas('toast_error', 'Dokumen Tidak Ditemukan');
});

test('Edit submission status document', function () {
    $thesis = Thesis::factory()->create();

    $this->actingAs($this->admin);
    $response = $this->get(route('document-management.edit', $thesis->id));
    $response->assertOK();

    $response = $this->put(route('document-management.update', $thesis->id), [
        "submission_status" => fake()->randomElement([null, 1, 2]),
    ]);

    $response->assertSessionHas('toast_success', "Tugas Akhir Diperbarui");
    $response->assertRedirect(route('document-management.index'));
});

test('Edit submission status fails', function () {
    $this->actingAs($this->admin);

    $response = $this->put(route('document-management.update', fake()->word()), [
        "submission_status" => fake()->randomElement([null, 1, 2]),
    ]);

    $response->assertStatus(302);
    $response->assertSessionHas('toast_error', "Tugas Akhir Tidak Ditemukan");
});

test('Edit submission status multiple document', function () {
    $thesis = Thesis::factory()->count(10)->create();

    $thesisIDs = $thesis->pluck('id')->toArray();

    $this->actingAs($this->admin);

    $response = $this->put(route('document-management.update-submission-status'), [
        "thesisIDs" => $thesisIDs,
        "submission_status" => fake()->randomElement([
            SubmissionStatusEnum::ACCEPTED->value,
            SubmissionStatusEnum::DECLINED->value,
            SubmissionStatusEnum::PENDING->value
        ]),
        'note' => fake()->text(),
    ]);

    $response->assertSessionHas('toast_success', "Tugas Akhir Diperbarui");
    $response->assertRedirect(route('document-management.index'));
});

test('Edit submission status multiple document fails', function () {
    $thesis = Thesis::factory()->count(10)->create();

    $this->actingAs($this->admin);

    $response = $this->put(route('document-management.update-submission-status'), [
        "submission_status" => fake()->randomElement([
            SubmissionStatusEnum::ACCEPTED->value,
            SubmissionStatusEnum::DECLINED->value,
            SubmissionStatusEnum::PENDING->value
        ]),
        'note' => fake()->text(),
    ]);

    $response->assertSessionHas('toast_error', "ID Tugas Akhir Wajib Dikirimkan");
});

afterEach(function () {
    DB::rollBack();
});
