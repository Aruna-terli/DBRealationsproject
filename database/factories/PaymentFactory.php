<?php

namespace Database\Factories;
use App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = Payment::class;
    public function definition()
    {
        return [
            'r_payment_id' => $this->faker->uuid,
        
            'method' => 'Card Payment', // You can modify this based on your application
            'currency' => 'USD', // You can modify this based on your application
            'user_email' => $this->faker->unique()->safeEmail,
            'amount' => $this->faker->randomFloat(2, 10, 500), // Random amount between 10 and 500
            'json_response' => $this->faker->text,

        ];
    }
}
