<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Business;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BusinessDocument;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Cache;

class SuperAdminController extends Controller
{
    //
    public function getTransactionsReport(Request $request)
    {
        $request->validate([
            'tx_date' => 'date'
        ]);

        // request date can be empty for all time or have a value for a particular day
        $result = null;
        if ($request->tx_date) {
            $result = $this->fetchTxByDate(Date::parse($request->date));
        } else {
            $result = $this->fetchAllTx();
        }

        return $this->sendSuccess("Transaction Report fetched successfully", [
            // "transactions_report" => $result,
            // "businesses" => [
            //     "count" => $result->businesses_count,
            // ]
            "result" => $result
        ]);
    }

    private function fetchTxByDate(Date $date)
    {
        $tx_date = $date->format("Y-m-d");
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
        return $report;
    }

    private function fetchAllTx()
    {
        // count
        // get all time pending tx
        // get all time successful tx
        //  get all time failed

        // amount
        // get all time pending amount
        // get all time success amount
        // all time failed amount

        $result = Cache::remember("admin_tx_stats", 100000, function () {
            $res = DB::select("
            select sum(case transaction_status when 'pending' then 1 else 0 end) as pending_tx_count,
            sum(case transaction_status when 'successful' then 1 else 0 end) as successful_tx_count,
            sum(case transaction_status when 'failed' then 1 else 0 end) as failed_tx_count,
            sum(case transaction_status when 'pending' then amount else 0 end) as total_pending_amount,
            sum(case transaction_status when 'successful' then amount else 0 end) as total_successful_amount,
            sum(case transaction_status when 'failed' then amount else 0 end) as total_failed_amount,
                null as total_businesses
            from transactions
            union 
            select 
            null as pending_tx_count,
            null as successful_tx_count,
            null as failed_tx_count,
            null as total_pending_amount,
            null as total_successful_amount,
            null as total_failed_amount,
            count(*) as total_businesses
            from businesses");
            return [
                "success" => [
                    "value" => $res[0]->total_successful_amount,
                    "count" => $res[0]->successful_tx_count
                ],
                "pending" => [
                    "value" => $res[0]->total_pending_amount,
                    "count" => $res[0]->pending_tx_count
                ],
                "failed" => [
                    "value" => $res[0]->total_failed_amount,
                    "count" => $res[0]->failed_tx_count
                ],
                "businesses" => [
                    "count" => $res[1]->total_businesses
                ]
            ];
        });
        return $result;
    }

    public function getTotalBusinesses()
    {
        $count = Business::count();
        return $this->sendSuccess("Businesses fetched successful", [
            "total_businesses" => $count
        ]);
    }


    public function getProductsCommissions(Request $request)
    {
        $per_page = $request->per_page ?? 20;
        $products = Product::with('biller', 'productCategory',)
            ->withSum(
                ['transactions' => function ($query) {
                    $query->where('transaction_status', "success");
                }],
                'owner_commission'
            )
            // ->whereId(2)->first()
            ->paginate()->appends(request()->query());

        return $this->sendSuccess("Products commissions fetched successfully", [
            "products" => $products
        ]);
    }
}
