<?php

namespace Database\Factories;

use App\Models\Biller;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mockery\Undefined;

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
        $has_fee = $this->faker->boolean;
        $has_range = $this->faker->boolean;
        return [
            'name' => $this->faker->word,
            // replace white space with underscore
            'shortname' => $this->faker->word,
            'biller_id' => Biller::all()->random()->id,
            'description' => $this->faker->randomElement(['fixed', 'percentage']),
            'vendor_code' => $this->faker->slug,
            'up_price' => $this->faker->randomFloat(2, 0, 100),
            'up_product_key' => $this->faker->slug,
            'service_type' => $this->faker->randomElement(['mtn_airtime', 'mtn_data', 'mtn_tv', 'mtn_internet']),
            'logo' => $this->faker->imageUrl(),
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
            'has_fee' =>  $has_fee,
            'fee_configuration' =>  $has_fee ?
                [
                    'type' => $this->faker->randomElement(['fixed', 'percentage']),
                    'has_range' => $has_range,
                    'range' => $has_range ? [[
                        'min' => $this->faker->randomFloat(2, 0, 30),
                        'max' => $this->faker->randomFloat(2, 30, 100),
                        'value' => $this->faker->randomFloat(2, 0, 10),
                    ]] : null,
                    'cap' => $this->faker->randomFloat(2, 0, 100),
                    'value' => $this->faker->randomFloat(2, 0, 100),
                ]
                : null,
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'implementation_code' => $this->faker->randomElement(['fixed', 'percentage']),
        ];
    }
}
