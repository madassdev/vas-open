<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Models\Business;
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
