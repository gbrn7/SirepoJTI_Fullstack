<?php

use App\Models\Lecturer;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::beginTransaction();

    $this->lecturer = Lecturer::factory()->create();
    $this->lecturer->assignRole('lecturer');
});

test('Open Thesis Submission Lecturer', function () {
    $this->actingAs($this->lecturer, 'lecturer');

    $response = $this->get(route('thesis-submission-lecturer.index'));

    $response->assertOK();
});

test('Open Thesis Submission Lecturer By Guest User', function () {
    $response = $this->get(route('thesis-submission-lecturer.index'));

    $response->assertStatus(302);
    $response->assertRedirect(route('signIn.student'));
});

afterEach(function () {
    DB::rollBack();
});
