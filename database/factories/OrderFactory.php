<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' =>fake()->unique()->name(),
            'delivered_date' =>fake()->date(),
            'pickup_address' =>fake()->address(),
            'longitude_pickup_address' =>fake()->address(),
            'latitude_pickup_address' =>fake()->address(),
            'longitude_deliver_address' =>fake()->address(),
            'latitude_deliver_address' =>fake()->address(),
            'deliver_address' =>fake()->address(),
            'quantity' => fake()->numberBetween(1, 10),
            'description' =>fake()->paragraph(),
            'price' =>fake()->randomFloat(2, 10, 100),
            'etat' =>fake()->randomElement(['pending', 'accepted', 'ongoing', 'delivered', 'rejected', 'cancelled']),
            'client_id' => Client::factory()->create()->id,
            'driver_id' => Driver::factory()->create()->id,
            // Add more attributes if needed

        ];
    }
}
