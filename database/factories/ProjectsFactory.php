<?php

namespace Database\Factories;
use App\Models\Projects;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Projects::class;
    public function definition()
    {
        return [
            'project_name' => $this->faker->sentence(3),
            'Amount' => $this->faker->randomFloat(2, 100, 1000),
            'project_type' => $this->faker->randomElement(['e-commernce','health','gaming','LMS','others']),
            'description' => $this->faker->paragraph(2),
            'payment_status' => '0',
            'employe_id' => '0',
            'user_id' => '0',
            'role_id' => '0',
        ];

        
    }
}
