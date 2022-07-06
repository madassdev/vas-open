<?php

namespace Database\Factories;

use App\Models\Biller;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'biller_id' => Biller::all()->random()->id,
            'description' => $this->faker->randomElement(['fixed', 'percentage']),
            'product_code' => $this->faker->randomElement(['fixed', 'percentage']),
            'logo' => $this->faker->randomElement(['fixed', 'percentage']),
            'product_category_id' => ProductCategory::all()->random()->id,
            'has_validation' => $this->faker->numberBetween(0, 1),
            'enabled' => $this->faker->numberBetween(0, 1),
            'service_status' => $this->faker->numberBetween(0, 1),
            'deployed' => $this->faker->numberBetween(0, 1),
            'min_amount' => $this->faker->randomFloat(2, 0, 100),
            'max_amount' => $this->faker->randomFloat(2, 0, 100),
            'commission_type' => $this->faker->randomElement(['fixed', 'percentage']),
            'provider_commission_value' => $this->faker->randomFloat(2, 0, 100),
            'provider_commission_cap' => $this->faker->randomFloat(2, 0, 100),
            'provider_commission_amount_cap' => $this->faker->randomFloat(2, 0, 100),
            'integrator_commission_value' => $this->faker->randomFloat(2, 0, 100),
            'integrator_commission_cap' => $this->faker->randomFloat(2, 0, 100),
            'integrator_commission_amount_cap' => $this->faker->randomFloat(2, 0, 100),
            'has_fee' => $this->faker->numberBetween(0, 1),
            'fee_configuration' => $this->faker->randomElement(['fixed', 'percentage']),
            // 'source' => $this->faker->text,
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'implementation_code' => $this->faker->randomElement(['fixed', 'percentage']),
        ];
    }
}
