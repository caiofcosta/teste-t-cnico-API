<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'title' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['meeting', 'task', 'event']),
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('-1 days', '+1 days'),
            'end_date' => $this->faker->dateTimeBetween('now', '+2 days'),
            'status' => $this->faker->randomElement(['aberto', 'concluído']),
        ];
    }
}
