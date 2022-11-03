<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletLog>
 */
class WalletLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'wallet_id' => Wallet::all()->random()->id,
            'transaction_id' => Transaction::all()->random()->id,
            'prev_balance' => $this->faker->randomFloat(2, 0, 100),
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'new_balance' => $this->faker->randomFloat(2, 0, 100),
            'description' => $this->faker->text,
            'entry_type' => $this->faker->randomElement(['data', 'file', 'both']),
            'wallet_type' => $this->faker->randomElement(['main', 'commission']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
