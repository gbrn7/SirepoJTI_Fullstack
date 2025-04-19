<?php

use App\Models\Admin;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::beginTransaction();
    $this->admin = Admin::factory()->create();
});

test('Open Dashboard Page', function () {
    $this->actingAs($this->admin, 'admin');

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
