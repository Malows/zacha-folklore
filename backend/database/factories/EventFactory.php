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
            'name' => $this->faker->name,
            'address' => $this->faker->streetAddress,
            'location' => [
                'lat' => $this->faker->latitude,
                'lng' => $this->faker->longitude,
            ],
            'event_day' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'started_at' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'is_active' => false,
            'reserved_tickets' => $this->faker->numberBetween(0, 100),
            'pre_paid_reserved_tickets' => $this->faker->numberBetween(0, 100),
            'common_tickets' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the event is active.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => true,
            ];
        });
    }
}
