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
            "required|string|in:test,live"
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
}
