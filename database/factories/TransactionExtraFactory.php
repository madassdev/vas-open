<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionExtra>
 */
class TransactionExtraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'transaction_id' => $this->faker->randomNumber(),
            'request_type' => $this->faker->randomElement(['data', 'file', 'both']),
            'business_headers' => $this->faker->text,
            'business_body' => $this->faker->text,
            'provider_request' => $this->faker->text,
            'provider_response' => $this->faker->text,
            'commission_configuration' => $this->faker->text,
            'ip_address' => $this->faker->ipv4,
            'business_response' => $this->faker->text,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
