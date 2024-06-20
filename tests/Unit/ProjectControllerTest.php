<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Projects;
use App\Models\User;


class ProjectControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function test_can_create_project()
    {
        $this->actingAs($this->user);
        // $projectData = Projects::factory()->make()->toArray();
        $data = [
            
            'name' => 'test project'.mt_rand(100, 999),
            'price' => '1000',
            'type' => 'others',
            'description' => 'test project',
          
        ];


        $response = $this->post('/projects', $data);

        $response->assertStatus(302);// Assuming successful redirect
          

        $this->assertDatabaseHas('projects', ['name' => $data['name']]);
    }

    public function test_can_update_project()
    {
        $this->actingAs($this->user);
        $project = Projects::factory()->create();

        $updatedData = [
            'name' => 'Updated Project Name',
            'price' => 999,
            'type' => 'others',
            'description' => 'Updated Project Description',
        ];

        $response = $this->put("/projects/{$project->id}", $updatedData);

        $response->assertStatus(302); // Assuming successful redirect;

        $this->assertDatabaseHas('projects', ['name' => 'Updated Project Name']);
    }

    public function test_can_delete_project()
    {
        $this->actingAs($this->user);
        $project = Projects::factory()->create();

        $response = $this->delete("/projects/{$project->id}");

        $response->assertStatus(302) // Assuming successful redirect
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
