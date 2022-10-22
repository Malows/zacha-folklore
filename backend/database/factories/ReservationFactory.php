<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'amount' => $this->faker->numberBetween(1, 10),

            'uuid' => Str::uuid(),
            'qr_path' => $this->faker->filePath(),
            'qr_url' => $this->faker->url,

            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,

            'is_paid' => false,
            'is_used' => false,
        ];
    }

    /**
     * Indicate that the reservation is paid.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_paid' => true,
            ];
        });
    }

    /**
     * Indicate that the reservation is used.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function used()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_used' => true,
            ];
        });
    }
}
