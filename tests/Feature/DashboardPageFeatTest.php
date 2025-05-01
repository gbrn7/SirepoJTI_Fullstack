<?php

use App\Models\Admin;
use App\Models\Lecturer;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::beginTransaction();
    $this->admin = Admin::factory()->create();
    $this->admin->assignRole('admin');

    $this->lecturer = Lecturer::factory()->create();
    $this->lecturer->assignRole('lecturer');
});

test('Open Dashboard Page', function () {
    $this->actingAs($this->admin, 'admin');

    $response = $this->get(route('dashboard.index'));

    $response->assertOK();
});

test('Open Dashboard Page As Lecturer', function () {
    $this->actingAs($this->lecturer, 'lecturer');

    $response = $this->get(route('dashboard.index'));

    $response->assertOK();
});

test('Open Dashboard Page By Guest User', function () {
    $response = $this->get(route('dashboard.index'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

afterEach(function () {
    DB::rollBack();
});
