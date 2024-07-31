<?php

namespace Database\Factories;

use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake()->name(),
            'price'=>fake()->randomFloat(2,10,100),// Random price between 10 and 100
            'image'=>fake()->imageUrl(),
            'user_id'=>User::factory()->create()->id,
            'place_id'=>Place::factory()->create()->id,
        ];
    }
}
