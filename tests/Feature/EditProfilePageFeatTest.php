<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EditProfilePageFeatTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }

    public function test_fails_open_edit_profile(): void
    {
        $response = $this->get(route('user.editProfile', fake()->randomNumber()));

        $response->assertStatus(302);
        $response->assertRedirect(route('signIn.student'));
    }

    public function test_edit_student_profile(): void
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

        $response = $this->get(route('user.editProfile', $student->id));

        $response->assertStatus(200);

        $newPass = fake()->password();
        $response = $this->post(route('user.updateProfile', $student->id), [
            'old_password' => $pass,
            'new_password' => $newPass,
            'confirm_password' => $newPass,
        ]);

        $response->assertSessionHas('toast_success', 'Profil Diperbarui');
    }

    public function test_edit_student_profile_fails(): void
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

        $response = $this->get(route('user.editProfile', $student->id));

        $response->assertStatus(200);

        $newPass = fake()->password();
        $response = $this->post(route('user.updateProfile', $student->id), [
            'old_password' => $pass,
            'new_password' => $newPass,
            'confirm_password' => fake()->password(),
        ]);

        $response->assertSessionHas('toast_error');
    }

    public function test_edit_admin_profile(): void
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
            'isAdmin' => true,
        ]);

        $response = $this->get(route('user.editProfile', $admin->id));

        $response->assertStatus(200);

        $newPass = fake()->password();
        $response = $this->post(route('user.updateProfile', $admin->id), [
            'old_password' => $pass,
            'new_password' => $newPass,
            'confirm_password' => $newPass,
        ]);

        $response->assertSessionHas('toast_success', 'Profil Diperbarui');
    }

    public function test_edit_admin_profile_fails(): void
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
            'isAdmin' => true,
        ]);

        $response = $this->get(route('user.editProfile', $admin->id));

        $response->assertStatus(200);

        $newPass = fake()->password();
        $response = $this->post(route('user.updateProfile', $admin->id), [
            'old_password' => $pass,
            'new_password' => $newPass,
            'confirm_password' => fake()->password(),
        ]);

        $response->assertSessionHas('toast_error');
    }

    public function test_edit_lecturer_profile(): void
    {
        $pass = fake()->password();
        // Create a Lecturer
        $lecturer = Lecturer::factory()->create([
            'password' => $pass,
        ]);

        // Attempt to login
        $response = $this->post(route('signIn.user.authenticate'), [
            'username' => $lecturer->username,
            'password' => $pass,
            'isLecturer' => true,
        ]);

        $response = $this->get(route('user.editProfile', $lecturer->id));

        $response->assertStatus(200);

        $newPass = fake()->password();
        $response = $this->post(route('user.updateProfile', $lecturer->id), [
            'old_password' => $pass,
            'new_password' => $newPass,
            'confirm_password' => $newPass,
        ]);

        $response->assertSessionHas('toast_success', 'Profil Diperbarui');
    }

    public function test_edit_lecturer_profile_fails(): void
    {
        $pass = fake()->password();
        // Create a Lecturer
        $lecturer = Lecturer::factory()->create([
            'password' => $pass,
        ]);

        // Attempt to login
        $response = $this->post(route('signIn.user.authenticate'), [
            'username' => $lecturer->username,
            'password' => $pass,
            'isLecturer' => true,
        ]);

        $response = $this->get(route('user.editProfile', $lecturer->id));

        $response->assertStatus(200);

        $newPass = fake()->password();
        $response = $this->post(route('user.updateProfile', $lecturer->id), [
            'old_password' => $pass,
            'new_password' => $newPass,
            'confirm_password' => fake()->password(),
        ]);

        $response->assertSessionHas('toast_error');
    }


    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }
}
