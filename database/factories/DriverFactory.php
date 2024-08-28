<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use App\Models\Place; // Import Place model
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition()
    {
        // Get a random place_id from existing places
        $placeId = Place::inRandomOrder()->first()->id;

        return [
            'place_id' => $placeId, // Use existing place_id
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 100), // Random price between 10 and 100
            'image' => $this->faker->imageUrl(),
            'rating' => $this->faker->randomFloat(1, 0, 5), // Random rating between 0 and 5
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Driver $driver) {
            $user = User::factory()->make([
                'userable_id' => $driver->id,
                'userable_type' => Driver::class,
            ]);
            $driver->user()->save($user);
        });
    }
}
