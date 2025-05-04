<?php

use App\Models\Admin;
use App\Models\ThesisTopic;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::beginTransaction();
    $this->admin = Admin::factory()->create();
    $this->admin->assignRole('admin');
});

test('Open thesis topic management page', function () {
    $this->actingAs($this->admin);
    $response = $this->get(route('thesis-topic-management.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin_views.thesis-topic.index');
});

test('Open thesis topic management page fails', function () {
    $response = $this->get(route('thesis-topic-management.index'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

test('Create thesis topic data', function () {
    $this->actingAs($this->admin);

    $response = $this->post(route('thesis-topic-management.store'), [
        'topic' => fake()->sentence(),
    ]);

    $response->assertSessionHas('toast_success', "Data Topik Tugas Akhir Ditambahkan");
});

test('Create thesis topic data fails', function () {
    $this->actingAs($this->admin);

    $response = $this->post(route('thesis-topic-management.store'), []);

    $response->assertSessionHas('toast_error', "Data Topik Tugas Akhir Wajib Diisi");
});

test('Update thesis topic data', function () {
    $this->actingAs($this->admin);

    $thesisTopic = ThesisTopic::factory()->create();

    $response = $this->put(route('thesis-topic-management.update', $thesisTopic->id), [
        'topic' => fake()->sentence(),
    ]);

    $response->assertSessionHas('toast_success', "Data Topik Tugas Akhir Diperbarui");
});

test('Update thesis topic data fails get thesis topic', function () {
    $this->actingAs($this->admin);

    $response = $this->put(route('thesis-topic-management.update', fake()->word()), [
        'topic' => fake()->sentence(),
    ]);

    $response->assertStatus(302);
    $response->assertSessionHas('toast_error', 'Gagal Memperbarui Data Topik Tugas Akhir');
});

test('Delete thesis topic data', function () {
    $this->actingAs($this->admin);

    $thesisTopic = ThesisTopic::factory()->create();

    $response = $this->delete(route('thesis-topic-management.destroy', $thesisTopic->id));

    $response->assertSessionHas('toast_success', "Data Topik Tugas Akhir Dihapus");
});

test('Delete thesis topic data fails', function () {
    $this->actingAs($this->admin);

    $response = $this->delete(route('thesis-topic-management.destroy', fake()->word()));

    $response->assertSessionHas('toast_error', 'Gagal Menghapus Data Topik');
});


afterEach(function () {
    DB::rollBack();
});
