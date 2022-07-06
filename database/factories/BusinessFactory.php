<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
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
            'logo' => $this->faker->imageUrl(100, 100),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'enabled' => $this->faker->boolean,
            'current_env' => $this->faker->randomElement(['live', 'test']),
            'api_key' => $this->faker->word,
            'secret_key' => $this->faker->word,
            'webhook' => $this->faker->url,
            'website' => $this->faker->url,
            'business_category_id' => DB::table('business_categories')->inRandomOrder()->first()->id,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'account_number' => $this->faker->numberBetween(100000000, 999999999),
            'document_verified' => $this->faker->boolean,
            'live_enabled' => $this->faker->boolean,
            'ip_addresses' => $this->faker->ipv4,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
