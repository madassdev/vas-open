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
            'name' => $this->faker->randomElement([
                'MTN',
                'Airtel',
                '9mobile',
                'Orange',
                'Etisalat',
                'Zong',
                'Globecom',
                'Vodafone',
                'Telkom',
                'Telkomsel',
                'WAEC',
                'JAMB',
                "NECO",
                "NTV", 'Zain',
                'Uganda Telecom',
                'DSTV',
                'Startimes',
                'Zamtel',
                'Abuja Electricity',
                'Niger State Electricity',
                'College of Education Sciences',
                'University of Ibadan',
                'University of Nigeria',
                'University of Lagos',
                'University of Benin',
                'University of Abuja',
                'University of Kano',
                'University of Kogi',
                'University of Jos',
                'University of Port-Harcourt'
            ]),
            'shortname' => $this->faker->slug(),
            'biller_id' => Biller::all()->random()->id,
            'description' => $this->faker->randomElement(['fixed', 'percentage']),
            'product_code' => $this->faker->randomElement(['fixed', 'percentage']),
            'unit_cost' => $this->faker->randomFloat(2, 0, 100),
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
            'fee_configuration' =>  $has_fee ? json_encode(
                [
                    'type' => $this->faker->randomElement(['fixed', 'percentage']),
                    'has_range' => $has_range,
                    'range' => $has_range ? [
                        'min' => $this->faker->randomFloat(2, 0, 100),
                        'max' => $this->faker->randomFloat(2, 0, 100),
                        'value' => $this->faker->randomFloat(2, 0, 100),
                    ] : null,
                    'cap' => $this->faker->randomFloat(2, 0, 100),
                    'value' => $this->faker->randomFloat(2, 0, 100),
                ]
            ) : null,
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'implementation_code' => $this->faker->randomElement(['fixed', 'percentage']),
        ];
    }
}
