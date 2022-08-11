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
            $result = $this->fetchTxByDate(Date::parse($request->tx_date)->format('Y-m-d'));
        } else {
            $result = $this->fetchAllTx();
        }

        return $this->sendSuccess("Transaction Report fetched successfully", $result);
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
            select 
            null as pending_tx_count,
            count(*) as successful_tx_count,
            null as failed_tx_count,
            null as total_pending_amount,
            sum(amount) as total_successful_amount,
            null as total_failed_amount,
            null as total_businesses
            from transactions
            where transaction_status = 'successful'


            union
            select 
            count(*) as pending_tx_count,
            null as successful_tx_count,
            null as failed_tx_count,
            sum(amount) as total_pending_amount,
            null as total_successful_amount,
            null as total_failed_amount,
            null as total_businesses
            from transactions
            where transaction_status = 'pending'


            union
            select 
            null as pending_tx_count,
            null as successful_tx_count,
            count(*) as failed_tx_count,
            null as total_pending_amount,
            null as total_successful_amount,
            sum(amount) as total_failed_amount,
            null as total_businesses
            from transactions
            where transaction_status = 'failed'

            union
            select 
            null as pending_tx_count,
            null as successful_tx_count,
            null as failed_tx_count,
            null as total_pending_amount,
            null as total_successful_amount,
            null as total_failed_amount,
            count(*) as total_businesses
            from businesses
 ");
            return [
                "success" => [
                    "value" => $res[0]->total_successful_amount,
                    "count" => $res[0]->successful_tx_count
                ],
                "pending" => [
                    "value" => $res[1]->total_pending_amount,
                    "count" => $res[1]->pending_tx_count
                ],
                "failed" => [
                    "value" => $res[2]->total_failed_amount,
                    "count" => $res[2]->failed_tx_count
                ],
                "businesses" => [
                    "count" => $res[3]->total_businesses
                ]
            ];
        });
        return $result;
    }

    private function fetchTxByDate(string $date)
    {
        $result = Cache::remember("admin_tx_stats_" . $date, 100000, function () use ($date) {
            $res = DB::select("
            select 
            null as pending_tx_count,
            count(*) as successful_tx_count,
            null as failed_tx_count,
            null as total_pending_amount,
            sum(amount) as total_successful_amount,
            null as total_failed_amount,
            null as total_businesses
            from transactions
            where transaction_status = 'successful'
            and created_at >= '" . $date . " 00:00:00'
            and created_at <= '" . $date . " 23:59:59'
            
            
            union
            select 
            count(*) as pending_tx_count,
            null as successful_tx_count,
            null as failed_tx_count,
            sum(amount) as total_pending_amount,
            null as total_successful_amount,
            null as total_failed_amount,
            null as total_businesses
            from transactions
            where transaction_status = 'pending'
            and created_at >= '" . $date . " 00:00:00'
            and created_at <= '" . $date . " 23:59:59'
            
            
            union
            select 
            null as pending_tx_count,
            null as successful_tx_count,
            count(*) as failed_tx_count,
            null as total_pending_amount,
            null as total_successful_amount,
            sum(amount) as total_failed_amount,
            null as total_businesses
            from transactions
            where transaction_status = 'failed'
            and created_at >= '" . $date . " 00:00:00'
            and created_at <= '" . $date . " 23:59:59'

            union
            select
            null as pending_tx_count,
            null as successful_tx_count,
            null as failed_tx_count,
            null as total_pending_amount,
            null as total_successful_amount,
            null as total_failed_amount,
            count(*) as total_businesses
            from businesses
            where created_at >= '" . $date . " 00:00:00'
            and created_at <= '" . $date . " 23:59:59'       
");
            return [
                "success" => [
                    "value" => $res[0]->total_successful_amount,
                    "count" => $res[0]->successful_tx_count
                ],
                "pending" => [
                    "value" => $res[1]->total_pending_amount,
                    "count" => $res[1]->pending_tx_count
                ],
                "failed" => [
                    "value" => $res[2]->total_failed_amount,
                    "count" => $res[2]->failed_tx_count
                ],
                "businesses" => [
                    "count" => $res[3]->total_businesses
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
