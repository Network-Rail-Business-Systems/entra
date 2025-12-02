<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NetworkRailBusinessSystems\Entra\EntraToken;
use NetworkRailBusinessSystems\Entra\Tests\Data\User;

class EntraTokenFactory extends Factory
{
    protected $model = EntraToken::class;

    public function definition(): array
    {
        return [
            'access_token' => $this->faker->uuid(),
            'email' => $this->faker->email(),
            'expires' => $this->faker->date(),
            'refresh_token' => $this->faker->uuid(),
            'user_id' => User::factory(),
        ];
    }
}
