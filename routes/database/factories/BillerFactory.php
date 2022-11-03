<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Biller>
 */
class BillerFactory extends Factory
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
            'shortname' => $this->faker->name,
            'vendor_code' => $this->faker->ipv4(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'logo' => $this->faker->imageUrl(),
            'enabled' => $this->faker->boolean(80),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];

    }
}
