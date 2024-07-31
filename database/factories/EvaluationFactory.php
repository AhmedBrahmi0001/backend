<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment'=> fake()->text(),
            'driver_id' => Driver::factory()->create()->id,
            'client_id' => Client::factory()->create()->id,
        ];
    }
}
