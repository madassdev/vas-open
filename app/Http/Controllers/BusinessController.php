<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Models\Business;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    //

    public function switchEnv(Request $request)
    {
        $request->validate([
            "env" => "required|string|in:test,live"
        ]);
        // Perform series of checks...
        $business = auth()->user()->business;
        if (!$business->live_enabled) {
            return $this->sendError("[BUSINESS ENV ERROR]: Business is not enabled to toggle to live.");
        }
        $business->current_env = $request->env;
        $business->save();
        return $this->sendSuccess("Bussiness Env switched to live");
    }

    public function seed(Request $request)
    {
        DBSwap::setConnection('mysqltest');
        $amount = $request->amount ?? 1;
        $business = Business::find(1);
        $transactions = $business->createDemoTransaction($amount);
        return $transactions;
    }

    public function getBalance()
    {
        $business = auth()->user()->business;
        $env = $business->current_env;
        $live_stats = [
            "wallet_balance" => 0,
            "transactions" => [
                "failed_percentage" => 0,
                "success_percentage" => 0,
                "pending_percentage" => 0,
            ],
            "total_commission_earned" => 0,
            "total_fees_paid" => 0,
            "recent_transactions" => 0,
            "transactions_count" => 0,
            "transactions_volume" => 0,
        ];
        $test_stats = [
            "wallet_balance" => 1000,
            "transactions" => [
                "failed_percentage" => 8,
                "success_percentage" => 80,
                "pending_percentage" => 12,
            ],
            "total_commission_earned" => 140,
            "total_fees_paid" => 23,
            "recent_transactions" => Transaction::latest()->take(rand(1, 5))->get(),
            "transactions_count" => rand(5, 20),
            "transactions_volume" => rand(2000, 10000),
        ];

        $stats = $env == "live" ? $live_stats : $test_stats;

        return $this->sendSuccess("Stats fetched successfully!", ["stats" => $stats]);;
    }

    // 1. Percentage of failed, pending and successful transaction 
    // 2. Wallet balance 
    // 3. Total commission earned 
    // 4. Total fees paid 
    // 5. Recent transactions 
    // 6. Count of transactions 
    // 7. Volume of transactions 
    // 8. Filter per product 
    // 9. Date range filter 
}
