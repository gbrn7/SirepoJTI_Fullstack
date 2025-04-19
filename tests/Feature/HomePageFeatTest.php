<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Thesis;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HomePageFeatTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }
    /**
     * A basic feature test example.
     */
    public function test_home_page(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('public_views.home');
    }

    public function test_download_files(): void
    {
        $thesis = Thesis::with('files')->first();

        if ($thesis) {
            if ($thesis->files()) {
                $student = Student::first();

                $response = $this->actingAs($student)->get(route('detail.document', $thesis->id));

                $response->assertStatus(200);
                $response->assertViewIs('public_views.detail_document');

                $response = $this->actingAs($student)->get(route('detail.document.download', ["thesis_id" => $thesis->id, "file_name" => $thesis->files()->first()->file_name]));

                $response->assertStatus(200);
                $response->assertHeader('Content-Type', 'application/pdf');
                $response->assertHeader('Content-disposition', 'inline; filename="' . $thesis->files()->first()->file_name . '.pdf"');
            }
        } else {
            $this->assertTrue(true);
        }
    }

    public function test_download_files_fails(): void
    {
        $thesis = Thesis::with('files')->first();

        if ($thesis) {
            if ($thesis->files()) {

                $response = $this->get(route('detail.document', $thesis->id));

                $response->assertStatus(200);
                $response->assertViewIs('public_views.detail_document');

                $response = $this->get(route('detail.document.download', $thesis->files()->first()->file_name));

                $response->assertStatus(302);
                $response->assertRedirect(route('signIn.student'));
            }
        } else {
            $this->assertTrue(true);
        }
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }
}
