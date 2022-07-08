<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Models\Business;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function getLowBalanceThreshold()
    {
        $business = auth()->user()->business;
        return $this->sendSuccess("Business Low Balance Threshold Fetched successfully", [
            "low_balance_threshold" => $business->low_balance_threshold
        ]);
    }

    public function setLowBalanceThreshold(Request $request)
    {
        $request->validate([
            "low_balance_threshold" => "required|numeric|min:0"
        ]);
        $business = auth()->user()->business;
        $business->low_balance_threshold = $request->low_balance_threshold;
        $business->save();
        return $this->sendSuccess("Business Low Balance Threshold Updated successfully", [
            "low_balance_threshold" => $business->low_balance_threshold ?? [],
        ]);
    }

    public function getWebhookUrl()
    {
        $business = auth()->user()->business;
        return $this->sendSuccess("Business Webhook Url Fetched successfully", [
            "webhook" => $business->webhook,
        ]);
    }

    public function setWebhookUrl(Request $request)
    {
        $request->validate([
            "webhook_url" => "required|url"
        ]);
        $business = auth()->user()->business;
        $business->webhook = $request->webhook_url;
        $business->save();
        return $this->sendSuccess("Business Webhook Url Updated successfully", [
            "webhook" => $business->webhook,
        ]);
    }

    public function getWhitelistIps()
    {
        $business = auth()->user()->business;
        return $this->sendSuccess("Business Whitelisted Ips fetched successfully", [
            "ip_addresses" => $business->ip_addresses,
        ]);
    }

    public function setWhitelistIps(Request $request)
    {
        $request->validate([
            "ip_addresses" => "required|string",
        ]);

        // $request->validate([
        //     "ip_addresses" => "required|array",
        //     "ip_addresses.*" => "required|ipv4",
        // ]);

        // $ip_addresses = collect($request->ip_addresses)->unique()->toArray();
        $comma_separated_addresses = str_replace(' ', '', $request->ip_addresses);
        $addresses_to_array = explode(',', $comma_separated_addresses);
        $validator = Validator::make(["ip_addresses" => $addresses_to_array], [
            "ip_addresses" => "required|array",
            "ip_addresses.*" => "required|ipv4",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ], 422);
        }

        $business = auth()->user()->business;
        $business->ip_addresses = $comma_separated_addresses;
        $business->save();
        return $this->sendSuccess("Business Whitelisted Ips updated successfully", [
            "ip_addresses" => $business->ip_addresses ?? [],
        ]);
    }


    public function getBalance()
    {
        // @TODO: Sort balance threshold logic
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
