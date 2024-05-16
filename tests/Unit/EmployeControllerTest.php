<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;



use App\Models\User;
use App\Models\Projects;
use App\Models\Payment;

class EmployeControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function test_can_create_employee()
    {
        $data = [
            
            'full_name' => 'Test User',
            'email_id' => 'test1_' . time() . '@example.com',
            'phone_no' => '1234567890',
            'password' => 'password123',
            're_password' => 'password123',
            'gender' => 'Male',
            'role' => '2',
            '_token' =>csrf_token(),
        ];

        $response = $this->post('/employes', $data);

        $response->assertStatus(302);// Assuming successful redirect
            // ->assertSessionHas('success');

        // $this->assertDatabaseHas('users', ['email' => $employeeData['email']]);
    }

    public function test_can_update_employee()
    {
        $employee = User::factory()->create(['role' => 2]);

        $updatedData = [
            'full_name' => 'Updated Employee Name',
           
            'phone_no' => '9876543210',
            'gender' => 'Female',
        ];

        $response = $this->put("/employes/{$employee->id}", $updatedData);

        $response->assertStatus(302); // Assuming successful redirect
            // ->assertSessionHas('success');

        // $this->assertDatabaseHas('users', ['name' => 'Updated Employee Name']);
    }

    public function test_can_delete_employee()
    {
        $employee = User::factory()->create(['role' => 2]);

        $response = $this->delete("/employes/{$employee->id}");

        $response->assertStatus(302); // Assuming successful redirect
            // ->assertSessionHas('success');

        // $this->assertDatabaseMissing('users', ['id' => $employee->id]);
    }
}
