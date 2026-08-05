<?php

namespace NetworkRailBusinessSystems\Entra\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use NetworkRailBusinessSystems\Entra\Models\EntraToken;

class EntraTokenFactory extends Factory
{
    protected $model = EntraToken::class;

    public function definition(): array
    {
        /** @var class-string<Model> $userModel */
        $userModel = config('entra.models.user');

        return [
            'access_token' => $this->faker->uuid(),
            'expires' => $this->faker->date(),
            'refresh_token' => $this->faker->uuid(),
            'user_id' => $userModel::factory(),
        ];
    }

    public function expired(): self
    {
        return $this->state([
            'expires' => Carbon::yesterday(),
        ]);
    }
}
