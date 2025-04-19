<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Student;
use Tests\TestCase;

class AuthenticationFeatTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_open_student_login_page(): void
    {
        $response = $this->get(route('signIn.student'));

        $response->assertStatus(200);
    }

    public function test_open_admin_login_page(): void
    {
        $response = $this->get(route('signIn.admin'));

        $response->assertStatus(200);
    }

    public function test_open_lecturer_login_page(): void
    {
        $response = $this->get(route('signIn.lecturer'));

        $response->assertStatus(200);
    }

    public function test_successfull_student_login(): void
    {
        $pass = fake()->password();
        // Create a Student
        $student = Student::factory()->create([
            'password' => $pass,
        ]);

        // Attempt to login
        $response = $this->post(route('signIn.user.authenticate'), [
            'username' => $student->username,
            'password' => $pass,
        ]);

        $response->assertRedirect(route('welcome'));
        $this->assertAuthenticatedAs($student);
    }

    public function test_unsuccessful_student_login(): void
    {
        // Attempt to login
        $response = $this->post(route('signIn.user.authenticate'), [
            'username' => fake()->userName(),
            'password' => fake()->password(),
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('toast_error');
    }

    public function test_successfull_admin_login(): void
    {
        $pass = fake()->password();
        // Create a Admin
        $admin = Admin::factory()->create([
            'password' => $pass,
        ]);

        // Attempt to login
        $response = $this->post(route('signIn.user.authenticate'), [
            'username' => $admin->username,
            'password' => $pass,
            'isAdmin' => true
        ]);

        $response->assertRedirect(route('welcome'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_unsuccessful_admin_login(): void
    {
        // Attempt to login
        $response = $this->post(route('signIn.user.authenticate'), [
            'username' => fake()->userName(),
            'password' => fake()->password(),
            'isAdmin' => true
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('toast_error');
    }
}
