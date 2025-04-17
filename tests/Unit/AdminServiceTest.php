<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Repositories\AdminRepository;
use App\Services\AdminService;
use Exception;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{

    /**
     * A basic unit test example.
     */
    public function test_get_admin_by_id(): void
    {
        $admin = Admin::factory()->make();

        $adminRepository = \Mockery::mock(AdminRepository::class, function (MockInterface $mock) use ($admin) {
            $mock->shouldReceive('getAdminByID')->andReturn($admin);
        });

        $adminService = new AdminService($adminRepository);

        $this->assertEquals($admin, $adminService->getAdminByID(1));
    }

    public function test_get_admin_by_id_return_null(): void
    {
        $adminRepository = \Mockery::mock(AdminRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getAdminByID')->andReturn(null);
        });

        $adminService = new AdminService($adminRepository);

        $this->assertNull($adminService->getAdminByID('s'));
    }

    public function test_update_admin(): void
    {
        $admin = Admin::factory()->make();

        $adminRepository = Mockery::mock(AdminRepository::class, function (MockInterface $mock) use ($admin) {
            $mock->shouldReceive('getAdminByID')->andReturn($admin);

            $mock->shouldReceive('updateAdmin')->andReturn(true);
        });

        $adminService = new AdminService($adminRepository);

        $updateAdmin = $adminService->updateAdmin(1, [
            "name" => "testEdit",
        ]);


        $this->assertTrue($updateAdmin);
    }

    public function test_not_found_admin_update_admin(): void
    {

        $adminRepository = Mockery::mock(AdminRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getAdminByID')->andReturn(null);

            $mock->shouldReceive('updateAdmin')->andReturn(false);
        });

        $adminService = new AdminService($adminRepository);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Data Dosen Tidak Ditemukan');

        $adminService->updateAdmin(1, [
            "name" => "testEdit",
        ]);
    }

    public function test_failed_update_admin(): void
    {
        $admin = Admin::factory()->make();

        $adminRepository = Mockery::mock(AdminRepository::class, function (MockInterface $mock) use ($admin) {
            $mock->shouldReceive('getAdminByID')->andReturn($admin);

            $mock->shouldReceive('updateAdmin')->andReturn(false);
        });

        $adminService = new AdminService($adminRepository);

        $updateAdmin = $adminService->updateAdmin(1, [
            "name" => "testEdit",
        ]);


        $this->assertFalse($updateAdmin);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
