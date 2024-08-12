<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);
    }

    /** @test */
    public function admin_can_create_employee()
    {
        $division = Division::factory()->create();

        $response = $this->actingAs($this->admin, 'sanctum')
            ->postJson('api/employees', [
                'image' => 'path/to/image.jpg',
                'name' => 'John Doe',
                'phone' => '123456789',
                'division' => $division->id,
                'position' => 'Developer',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Karyawan berhasil ditambahkan',
            ]);

        $this->assertDatabaseHas('employees', ['name' => 'John Doe']);
    }

    /** @test */
    public function admin_can_update_employee()
    {
        $employee = Employee::factory()->create();
        $division = Division::factory()->create();

        $response = $this->actingAs($this->admin, 'sanctum')
            ->putJson('api/employees/' . $employee->id, [
                'name' => 'Jane Doe',
                'division' => $division->id,
                'position' => 'Manager',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Karyawan berhasil diperbaharui',
            ]);

        $this->assertDatabaseHas('employees', ['name' => 'Jane Doe']);
    }

    /** @test */
    public function admin_can_delete_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($this->admin, 'sanctum')
            ->deleteJson('api/employees/' . $employee->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Karyawan berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }

    /** @test */
    public function non_admin_cannot_perform_cud_operations()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'password' => Hash::make('password123'),
        ]);

        $division = Division::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('api/employees', [
                'image' => 'path/to/image.jpg',
                'name' => 'John Doe',
                'phone' => '123456789',
                'division' => $division->id,
                'position' => 'Developer',
            ]);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized.',
            ]);
    }
}
