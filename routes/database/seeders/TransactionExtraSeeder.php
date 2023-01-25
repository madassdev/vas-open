<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for each transaction, create a transaction extra
        \App\Models\Transaction::all()->each(function ($transaction) {
            $transaction->extra()->create([
                'request_type' => 'POST',
                'business_headers' => json_encode([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $transaction->business->token,
                ]),
                'business_body' => json_encode([
                    'amount' => $transaction->amount,
                    'phone' => $transaction->phone,
                    'reference' => $transaction->reference,
                ]),
                'provider_request' => json_encode([
                    'amount' => $transaction->amount,
                    'phone' => $transaction->phone,
                    'reference' => $transaction->reference,
                ]),
                'provider_response' => json_encode([
                    'status' => 'success',
                    'message' => 'Transaction successful',
                    'data' => [
                        'transaction_id' => $transaction->id,
                        'reference' => $transaction->reference,
                        'amount' => $transaction->amount,
                        'phone' => $transaction->phone,
                        'status' => 'success',
                        'message' => 'Transaction successful',
                    ],
                ]),
                'commission_configuration' => json_encode([
                    'commission' => 0,
                    'commission_type' => 'percentage',
                    'commission_amount' => 0,
                    'commission_percentage' => 0,
                    'commission_fixed' => 0,
                    'commission_min' => 0,
                    'commission_max' => 0,
                ]),
                'ip_address' => '127.0.0.1',
                'business_response' => json_encode([
                    'status' => 'success',
                    'message' => 'Transaction successful',
                    'data' => [
                        'transaction_id' => $transaction->id,
                        'reference' => $transaction->reference,
                        'amount' => $transaction->amount,
                        'phone' => $transaction->phone,
                        'status' => 'success',
                        'message' => 'Transaction successful',
                    ],
                ]),

            ]);
        });
    }
}
