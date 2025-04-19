<?php

namespace Tests\Feature;


use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ThesisSubmissionTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $student = Student::first();

        $this->actingAs($student);
    }
    /**
     * A basic feature test example.
     */
    public function test_open_thesis_submission_test(): void
    {
        $response = $this->get(route('thesis-submission.index'));

        $response->assertStatus(200);
    }

    public function test_open_thesis_submission_test_fails(): void
    {
        Auth::logout();
        $response = $this->get(route('thesis-submission.index'));

        $response->assertStatus(302);
    }

    public function test_open_create_thesis_submission_test(): void
    {
        $response = $this->get(route('thesis-submission.create'));

        $response->assertStatus(200);
    }

    public function test_open_create_thesis_submission_test_fails(): void
    {
        Auth::logout();
        $response = $this->get(route('thesis-submission.create'));

        $response->assertStatus(302);
    }
}
