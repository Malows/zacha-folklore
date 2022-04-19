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
        ];
    }
}
