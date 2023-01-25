<?php

namespace Database\Factories;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletSplit>
 */
class WalletSplitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'transaction_id' => Transaction::all()->random()->id,
            'wallet_transaction_id' => WalletTransaction::all()->random()->id,
            'wallet_id' => Wallet::all()->random()->id,
            'wallet_type' => $this->faker->randomElement(['main', 'commission']),
            'transaction_type' => $this->faker->randomElement(['data', 'file', 'both']),
        ];
    }
}
