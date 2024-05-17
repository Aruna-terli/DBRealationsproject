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
            'email_id' => 'test1' . mt_rand(1000, 9999) . '@example.com',
            'phone_no' => '1234567890',
            'password' => 'password123',
            're_password' => 'password123',
            'gender' => 'Male',
            'role' => '2',
            '_token' =>csrf_token(),
        ];

        $response = $this->POST('employes', $data);
       

        $response->assertStatus(302);// Assuming successful redirect
            // ->assertSessionHas('success');

        $this->assertDatabaseHas('users', ['email' => $data['email_id']]);
    }

    public function test_can_update_employee()
    {
        $employee = User::factory()->create(['role' => 2]);

        $updatedData = [
            'full_name' => 'Updated Employee Name',
            'email_id' => $employee['email'],
            'phone_no' => '9876543210',
            'gender' => 'Female',
        ];

        $response = $this->PUT("employes/{$employee->id}", $updatedData);
       
        $response->assertStatus(302); // Assuming successful redirect
            // ->assertSessionHas('success');
            $this->assertDatabaseHas('users', [
                'id' => $employee->id,
                'name' => $updatedData['full_name'],
                'phone_no' => $updatedData['phone_no'],
                'gender' => $updatedData['gender'],
            ]);
    }

    public function test_can_delete_employee()
    {
        $employee = User::factory()->create(['role' => 2]);

        $response = $this->delete("/employes/{$employee->id}");

        $response->assertStatus(302); // Assuming successful redirect
            // ->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $employee->id]);
    }
}
