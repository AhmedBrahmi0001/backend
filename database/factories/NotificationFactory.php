<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Choose randomly between Driver and Client
        $notifiableType = $this->faker->randomElement([Driver::class, Client::class]);

        // Create a notifiable entity (Driver or Client)
        $notifiable = $notifiableType::factory()->create();

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'is_read' => $this->faker->boolean(),
            'notifiable_id' => $notifiable->id,
            'notifiable_type' => $notifiableType,
        ];
    }
}
