<?php

namespace App\Http\Controllers;

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
            "report" => $report
        ]);
    }
}
