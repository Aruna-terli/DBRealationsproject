<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Projects;


class ProjectControllerTest extends TestCase
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
    public function test_can_create_project()
    {
        // $projectData = Projects::factory()->make()->toArray();
        $data = [
            
            'project_name' => 'test project'.mt_rand(100, 999),
            'price' => '1000',
            'project_type' => 'others',
            'description' => 'test project',
          
        ];


        $response = $this->post('/projects', $data);

        $response->assertStatus(302);// Assuming successful redirect
          

        $this->assertDatabaseHas('projects', ['project_name' => $data['project_name']]);
    }

    public function test_can_update_project()
    {
        $project = Projects::factory()->create();

        $updatedData = [
            'project_name' => 'Updated Project Name',
            'price' => 999,
            'project_type' => 'others',
            'description' => 'Updated Project Description',
        ];

        $response = $this->put("/projects/{$project->id}", $updatedData);

        $response->assertStatus(302); // Assuming successful redirect;

        $this->assertDatabaseHas('projects', ['project_name' => 'Updated Project Name']);
    }

    public function test_can_delete_project()
    {
        $project = Projects::factory()->create();

        $response = $this->delete("/projects/{$project->id}");

        $response->assertStatus(302) // Assuming successful redirect
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
