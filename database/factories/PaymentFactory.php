<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' =>fake()->randomFloat(2, 10, 100),
            'payment_method' => 'cash', // Assuming only 'cash' payment method is used
            'status' =>fake()->randomElement(['pending', 'completed', 'failed']),
            'payment_date' =>fake()->dateTime(),
            'order_id'=>Order::factory()->create()->id,

        ];
    }
}
