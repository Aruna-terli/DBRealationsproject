<?php

namespace Tests\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
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
    

    public function test_can_register_user()
    {
        $data = [
            
            'full_name' => 'Test User',
            'email' => 'test1_' . mt_rand(100, 999) . '@example.com',
            'phone_no' => '1234567890',
            'password' => 'password123',
            're_password' => 'password123',
            'gender' => 'Male',
            'role' => '1',
            
        ];

        $response = $this->post('/savedata', $data);

        $response->assertStatus(302); // Assuming successful redirect
            // ->assertSessionHas('success');

        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    public function test_can_authenticate_user()
    {
        $email = 'test2_' .  mt_rand(100, 999) . '@example.com';
        $user = User::factory()->create([
            'email' => $email,
            'password' => bcrypt('password123'),
            'role' => 3,
        ]);

        $credentials = [
            'email' => $email,
            'password' => 'password123',
        ];

        $response = $this->post('/signup', $credentials);

        $response->assertStatus(302); 
        
            
            $this->assertDatabaseHas('users', ['email' => $credentials['email']]);

    }

   
}
