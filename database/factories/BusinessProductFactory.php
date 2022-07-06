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
            'business_id' => Business::all()->random()->id,
            'product_id' => Product::all()->random()->id,
            'commission_value' => $this->faker->randomFloat(2, 0, 100),
            'fee_configuration' => $this->faker->text,
            'enabled' => $this->faker->boolean,
            'created_by' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
