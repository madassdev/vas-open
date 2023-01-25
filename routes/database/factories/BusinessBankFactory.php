<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class BusinessBankFactory extends Factory
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
            'bankname' => $this->faker->randomElement(['FirstBank', 'United Bank of Africa', 'Zenith Bank', 'Access Bank', 'Diamond Bank', 'Ecobank', 'Fidelity Bank', 'First Bank', 'Guaranty Trust Bank', 'Heritage Bank', 'Keystone Bank', 'MainStreet Bank', 'Stanbic IBTC Bank', 'Standard Chartered Bank', 'Sterling Bank', 'Union Bank', 'Unity Bank', 'Wema Bank', 'Zoom Bank']),
            'account_number' => $this->faker->randomNumber(9),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
