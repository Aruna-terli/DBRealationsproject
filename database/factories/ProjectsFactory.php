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
            'name' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'type' => $this->faker->randomElement(['e-commernce','health','gaming','LMS','others']),
            'description' => $this->faker->paragraph(2),
            'status' => '0',
  
        ];

        
    }
}
