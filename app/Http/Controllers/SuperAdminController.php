<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    //
    public function getTransactionsReport(Request $request)
    {
        $tx_date = $request->tx_date ?? Carbon::today()->format("Y-m-d");
        $pending = Transaction::whereDate('created_at', $tx_date)->whereTransactionStatus('pending')->get();
        $success = Transaction::whereDate('created_at', $tx_date)->whereTransactionStatus('success')->get();
        $failed = Transaction::whereDate('created_at', $tx_date)->whereTransactionStatus('failed')->get();
        $businesses_count = Business::count();
       
        $report = [
            "tx_date" => $tx_date,
            "success" => [
                "value" => $success->sum('amount'),
                "count" => $success->count()
            ],
            "pending" => [
                "value" => $pending->sum('amount'),
                "count" => $pending->count()
            ],
            "failed" => [
                "value" => $failed->sum('amount'),
                "count" => $failed->count()
            ],
        ];

        return $this->sendSuccess("Transaction Report fetched successfully", [
            "transactions_report" => $report,
            "businesses" => [
                "count" => $businesses_count
            ]
        ]);
    }

    public function getTotalBusinesses()
    {
        $count = Business::count();
        return $this->sendSuccess("Businesses fetched successful", [
            "total_businesses" => $count
        ]);
    }

    public function getBusinesses(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $businesses = Business::paginate($per_page)->appends(request()->query());
        return $this->sendSuccess("Businesses fetched successful", [
            "businesses" => $businesses
        ]);
    }
}
