<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NetworkRailBusinessSystems\Entra\Tests\Data\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'azure_id' => $this->faker->word(),
            'business_phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'name' => $this->faker->name(),
            'office' => $this->faker->streetName(),
            'mobile_phone' => $this->faker->phoneNumber(),
            'title' => $this->faker->jobTitle(),
            'username' => $this->faker->userName(),
        ];
    }
}