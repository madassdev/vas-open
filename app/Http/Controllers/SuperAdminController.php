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
            'tx_date' => 'date',
        ]);

        $tx_date = $request->tx_date ?? now()->format('Y-m-d');
        // Dashboard (3 subsections)
        // Businesses
        // [All: 0 ] [Live: 3 ] [Testing: 5] [Transacting: ]

        // Transactions
        // [Todays Count: 0] 
        // [Todays Value: N1000] 
        // [Monthly Count: 50] 
        // [Monthly Value: N50,000]

        // Earnings
        // [Todays Commission: N500] 
        // [Todays Fees: N3000] 
        // [Monthly Commission: N7000] 
        // [Monthly Fees: N1000]

        // request date can be empty for all time or have a value for a particular day
        $result = null;

        $startOfMonth = Carbon::parse($tx_date)->startOfMonth()->format('Y-m-d');
        $monthly_report = $this->fetchTxByMonth($startOfMonth);
        $result = $this->fetchTxByDate(Date::parse($tx_date)->format('Y-m-d'));

        $business_report = $this->fetchBusinessReport();

        return $this->sendSuccess("Transaction Report fetched successfully", [
            "day_report" => $result,
            "month_report" => $monthly_report,
            "businesses" => $business_report,
            "tx_date" => $tx_date,
        ]);
    }

    private function fetchBusinessReport()
    {
        $result = Cache::remember("admin_businesses_stats", 100000, function () {
            $res = DB::select(
                "
                select 
                count(*) as all_businesses,
                0 as live_businesses,
                0 as test_businesses 
                from businesses

                union
                select 
                0 as all_businesses, 
                count(*) as live_businesses,
                0 as test_businesses 
                from businesses 
                WHERE current_env = 'live'
                
                union
                select 
                0 as all_businesses, 
                0 as live_businesses, 
                count(*) as test_businesses
                from businesses 
                WHERE current_env = 'test'
            "
            );

            $thirtyDaysAgo = Date::parse(now()->subDays(30))->format('Y-m-d');
            $transacting_businesses  = Business::whereHas('transactions', function ($q) use($thirtyDaysAgo) {
                $q->where('created_at', '>=', $thirtyDaysAgo);
            })->count();
            return [
                "all_businesses" => $res[0]->all_businesses,
                "live_businesses" => $res[1]->live_businesses,
                "test_businesses" => $res[2]->test_businesses,
                "transacting_businesses" => $transacting_businesses,
            ];
        });


        return $result;
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
            ");
            return [
                "successful" => [
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
            ];
        });
        return $result;
    }

    private function fetchTxByDate(string $date)
    {
        // no need to worry about SQL injection as the date was validated and it was also gotten as an output from thr date function from carbon
        // commission
        $result = Cache::remember("admin_tx_stats_" . $date, 100000, function () use ($date) {
            $res = DB::select(DB::raw("
                select 
                null as pending_tx_count,
                count(*) as successful_tx_count,
                null as failed_tx_count,
                null as total_pending_amount,
                sum(amount) as total_successful_amount,
                sum(integrator_commission) as total_commission,
                sum(fee) as total_fees,
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
                sum(integrator_commission) as total_commission,
                sum(fee) as total_fees,
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
                sum(integrator_commission) as total_commission,
                sum(fee) as total_fees,
                null as total_businesses
                from transactions
                where transaction_status = 'failed'
                and created_at >= '" . $date . " 00:00:00'
                and created_at <= '" . $date . " 23:59:59'
            "));
            return [
                "transactions" => [
                    "successful" => [
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
                    "total" => [
                        "value" => $res[0]->total_successful_amount + $res[1]->total_pending_amount + $res[2]->total_failed_amount,
                        "count" => $res[0]->successful_tx_count + $res[1]->pending_tx_count + $res[2]->failed_tx_count
                    ],
                ],
                "commissions" => [
                    "successful" => $res[0]->total_commission,
                    "pending" => $res[1]->total_commission,
                    "failed" => $res[2]->total_commission,
                    "total" => $res[0]->total_commission + $res[1]->total_commission + $res[2]->total_commission
                ],
                "fees" => [
                    "successful" => $res[0]->total_fees,
                    "pending" => $res[1]->total_fees,
                    "failed" => $res[2]->total_fees,
                    "total" => $res[0]->total_fees + $res[1]->total_fees + $res[2]->total_fees
                ],

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

    private function fetchTxByMonth($startOfMonth)
    {


        $today = now()->format('Y-m-d');
        // return $startOfMonth;

        $result = Cache::remember("admin_tx_stats_monthly" . $startOfMonth, 100000, function () use ($startOfMonth, $today) {
            $res = DB::select("
                select 
                null as pending_tx_count,
                count(*) as successful_tx_count,
                null as failed_tx_count,
                null as total_pending_amount,
                sum(amount) as total_successful_amount,
                sum(integrator_commission) as total_commission,
                sum(fee) as total_fees,
                null as total_failed_amount,
                null as total_businesses
                from transactions
                where transaction_status = 'successful'
                and created_at >= '" . $startOfMonth . " 00:00:00'
                and created_at <= '" . $today . " 23:59:59'
                
                
                union
                select 
                count(*) as pending_tx_count,
                null as successful_tx_count,
                null as failed_tx_count,
                sum(amount) as total_pending_amount,
                sum(integrator_commission) as total_commission,
                sum(fee) as total_fees,
                null as total_successful_amount,
                null as total_failed_amount,
                null as total_businesses
                from transactions
                where transaction_status = 'pending'
                and created_at >= '" . $startOfMonth . " 00:00:00'
                and created_at <= '" . $today . " 23:59:59'
                
                
                union
                select 
                null as pending_tx_count,
                null as successful_tx_count,
                count(*) as failed_tx_count,
                null as total_pending_amount,
                null as total_successful_amount,
                sum(amount) as total_failed_amount,
                sum(integrator_commission) as total_commission,
                sum(fee) as total_fees,
                null as total_businesses
                from transactions
                where transaction_status = 'failed'
                and created_at >= '" . $startOfMonth . " 00:00:00'
                and created_at <= '" . $today . " 23:59:59'
            ");
            return [
                "transactions" => [
                    "successful" => [
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
                    "total" => [
                        "value" => $res[0]->total_successful_amount + $res[1]->total_pending_amount + $res[2]->total_failed_amount,
                        "count" => $res[0]->successful_tx_count + $res[1]->pending_tx_count + $res[2]->failed_tx_count
                    ]
                ],
                "commissions" => [
                    "successful" => $res[0]->total_commission,
                    "pending" => $res[1]->total_commission,
                    "failed" => $res[2]->total_commission,
                    "total" => $res[0]->total_commission + $res[1]->total_commission + $res[2]->total_commission
                ],
                "fees" => [
                    "successful" => $res[0]->total_fees,
                    "pending" => $res[1]->total_fees,
                    "failed" => $res[2]->total_fees,
                    "total" => $res[0]->total_fees + $res[1]->total_fees + $res[2]->total_fees
                ],
            ];
        });
        return $result;
    }
}
