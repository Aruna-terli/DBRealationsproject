<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;



use App\Models\User;
use App\Models\Projects;
use App\Models\Payment;

use Illuminate\Support\Facades\Hash;


class ClientControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */


     public function test_can_get_all_clients()
     {
         $response = $this->get('/clients');
 
         $response->assertStatus(200);
             
     }
 
     public function test_can_create_client()
     {
         $data = [
            
             'full_name' => 'Test User',
             'email_id' => 'test1_' . time() . '@example.com',
             'phone_no' => '1234567890',
             'password' => 'password123',
             're_password' => 'password123',
             'gender' => 'Male',
             'role' => '1',
             '_token' =>csrf_token(),
         ];
 
      
         $response = $this->post('/clients', $data);
         $response->assertStatus(302) ; // Assuming successful redirect
           
     }
 
     public function test_can_update_client()
     {
         $client = User::factory()->create(['role' => 1]);
 
         $data = [
             'full_name' => 'Updated Name',
             'phone_no' => '9876543210',
             'gender' => 'Female',
         ];
 
         $response = $this->put("/clients/{$client->id}", $data);
 
         $response->assertStatus(302); // Assuming successful redirect
            
     }
 
     public function test_can_delete_client()
     {
         $client = User::factory()->create(['role' => 1]);
 
         $response = $this->delete("/clients/{$client->id}");
 
         $response->assertStatus(302) // Assuming successful redirect
             ->assertSessionHas('success');
     }
 
     public function test_can_assign_employee_to_project()
     {
         $employee = User::factory()->create(['role' => 2]);
         $project = Projects::factory()->create();
 
         $data = [
             'project_id' => $project->id,
             'employe_id' => $employee->id,
         ];
 
         $response = $this->post('/assignEmploye', $data);
 
         $response->assertStatus(302) // Assuming successful redirect
             ->assertSessionHas('success');
     }
   
}
