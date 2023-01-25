<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessProduct>
 */
class BusinessProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'business_id' => Business::factory(),
            'product_id' => Product::factory(),
            'commission_value' => $this->faker->randomFloat(2, 0, 100),
            'enabled' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
