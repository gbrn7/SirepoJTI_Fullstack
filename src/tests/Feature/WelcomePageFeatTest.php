<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomePageFeatTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_welcome_page(): void
    {
        $response = $this->get(route('welcome'));

        $response->assertStatus(200);
    }

    public function test_filter_year_page(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);

        $response = $this->get(route('filter.year.view'));
        $response->assertStatus(200);
    }

    public function test_filter_prody_page(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);

        $response = $this->get(route('filter.program-study.view'));
        $response->assertStatus(200);
    }

    public function test_filter_topic_page(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);

        $response = $this->get(route('filter.topic.view'));
        $response->assertStatus(200);
    }

    public function test_filter_author_page(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);

        $response = $this->get(route('filter.author.view'));
        $response->assertStatus(200);
    }

    public function test_filter_thesis_type_page(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);

        $response = $this->get(route('filter.thesis-type.view'));
        $response->assertStatus(200);
    }
}
