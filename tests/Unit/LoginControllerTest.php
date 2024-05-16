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
            'email_id' => 'test1_' . time() . '@example.com',
            'phone_no' => '1234567890',
            'password' => 'password123',
            're_password' => 'password123',
            'gender' => 'Male',
            'role' => '1',
            '_token' =>csrf_token(),
        ];

        $response = $this->post('/savedata', $data);

        $response->assertStatus(302); // Assuming successful redirect
            // ->assertSessionHas('success');

        // $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_can_authenticate_user()
    {
        $email = 'test2_' . time() . '@example.com';
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

        $response->assertStatus(200) // Assuming successful login
            ->assertViewIs('home'); // Assuming view after successful login is 'home'
    }

   
}
