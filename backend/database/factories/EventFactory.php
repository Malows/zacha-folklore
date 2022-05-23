<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'event_day' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'started_at' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'is_active' => $this->faker->boolean,
            'reserved_tickets' => $this->faker->numberBetween(0, 100),
            'pre_paid_reserved_tickets' => $this->faker->numberBetween(0, 100),
            'common_tickets' => $this->faker->numberBetween(0, 100),
        ];
    }
}
