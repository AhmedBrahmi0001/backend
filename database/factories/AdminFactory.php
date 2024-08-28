<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            // Define any Admin-specific attributes here
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Admin $admin) {
            $user = User::factory()->make([
                'userable_id' => $admin->id,
                'userable_type' => Admin::class,
            ]);
            $admin->user()->save($user);
        });
    }
}
