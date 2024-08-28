<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Client $client) {
            $user = User::factory()->make([
                'userable_id' => $client->id,
                'userable_type' => Client::class,
            ]);
            $client->user()->save($user);
        });
    }
}
