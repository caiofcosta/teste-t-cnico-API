<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'email_verified_at' => $this->faker->dateTime(),
            'password' => $this->faker->password(),
            'remember_token' => $this->faker->uuid(),
            'role' => $this->faker->randomElement(['admin', 'user']),
        ];
    }
}
