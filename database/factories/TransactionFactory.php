<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
            'idempotency_hash' => $this->faker->uuid,
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'business_reference' => $this->faker->uuid,
            'debit_reference' => $this->faker->uuid,
            'provider_debited_amount' => $this->faker->randomFloat(2, 0, 100),
            'integrator_debited_amount' => $this->faker->randomFloat(2, 0, 100),
            'payment_status' => $this->faker->boolean,
            'value_given' => $this->faker->boolean,
            'transaction_status' => $this->faker->boolean,
            'phone_number' => $this->faker->phoneNumber,
            'account_number' => $this->faker->phoneNumber,
            'status_code' => $this->faker->boolean,
            'status_message' => $this->faker->word,
            'retries' => $this->faker->numberBetween(0, 10),
            'narration' => $this->faker->sentence(),
            'product_price' => $this->faker->randomFloat(2, 0, 100),
            'fee' => $this->faker->randomFloat(2, 0, 100),
            'integrator_commission' => $this->faker->randomFloat(2, 0, 100),
            'owner_commission' => $this->faker->randomFloat(2, 0, 100),
            // 'is_settled' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
