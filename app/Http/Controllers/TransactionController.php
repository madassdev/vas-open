<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //

    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 20;
        $user = auth()->user();
        $business = $user->business;
        // $business->createDemoTransaction(rand(30,80));
        $query = Transaction::query()->where('business_id', $business->id);
        if ($request->category_id) {
            $category_id = $request->product_category_id;
            $query = $query->whereHas('product', function ($q) use ($category_id) {
                $q->where('product_category_id', '=', $category_id);
            });
        }
        if ($request->product_shortname) {
            $shortname = $request->product_shortname;
            $query = $query->whereHas('product', function ($q) use ($shortname) {
                $q->where('shortname', '=', $shortname);
            });
        }

        if ($request->product_id) {
            $query = $query->where('product_id', '=', $request->product_id);
        }

        if ($request->transaction_status) {
            $query = $query->where('transaction_status', '=', $request->transaction_status);
        }

        if ($request->transaction_reference) {
            $query = $query->where('transaction_reference', '=', $request->transaction_status);
        }

        if ($request->business_reference) {
            $query = $query->where('business_reference', '=', $request->transaction_status);
        }

        if ($request->provider_reference) {
            $query = $query->where('provider_reference', '=', $request->transaction_status);
        }

        if ($request->account_number) {
            $query = $query->where('account_number', '=', $request->account_number);
        }

        if ($request->start_date && $request->end_date) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $query = $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $transactions = $query->with('product.productCategory', 'product.biller')->paginate($per_page)->appends(request()->query());

        return $this->sendSuccess("Transactions fetched successful", [
            "transactions" => $transactions
        ]);

        // $business->createDemoTransaction(20);
    }

    public function show($transaction_id)
    {
        $user = auth()->user();
        $business = $user->business;
        $transaction = Transaction::whereId($transaction_id)->whereBusinessId($business->id)->first();
        if (!$transaction) {
            return $this->sendError("Transaction not found for this business",[], 404);
        }
        $transaction->load('product.productCategory', 'product.biller');
        return $this->sendSuccess("Transaction details retrieved successfully", [
            "transaction" => $transaction
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            "term" => "required|string|max:250",
        ]);
        $per_page = $request->per_page ?? 20;
        $user = auth()->user();
        $business = $user->business;
        $term = $request->term;

        $base_columns = [
            'business_reference',
            'transaction_reference',
            'provider_reference',
            'debit_reference',
            'idempotency_hash',
            'phone_number',
            'account_number',
        ];
        // $business->createDemoTransaction(rand(30,80));
        $query = Transaction::query()->where('business_id', $business->id);
        $query = $query->where(function ($q) use ($term, $base_columns) {
            $q->orWhereHas('product', function ($qu) use ($term) {
                $qu->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhere('description', 'LIKE', '%' . $term . '%')
                    ->orWhere('shortname', 'LIKE', '%' . $term . '%')
                    ->orWhere('product_code', 'LIKE', '%' . $term . '%')
                    ->orWhereHas('productCategory', function ($q) use ($term) {
                        $q->where('name', 'LIKE', '%' . $term . '%');
                    });
            });
            foreach ($base_columns as $column) {
                $q->orWhere($column, 'LIKE', '%' . $term . '%');
            }
        });
        $transactions = $query->with('product.productCategory', 'product.biller')->paginate($per_page)->appends(request()->query());
        return $this->sendSuccess("Transactions search successful", [
            "transactions" => $transactions
        ]);
    }

    public function download(Request $request)
    {
        $per_page = $request->per_page ?? 20;
        $user = auth()->user();
        $business = $user->business;
        // $business->createDemoTransaction(rand(30,80));
        $query = Transaction::query()->where('business_id', $business->id);
        if ($request->category_id) {
            $category_id = $request->product_category_id;
            $query = $query->whereHas('product', function ($q) use ($category_id) {
                $q->where('product_category_id', '=', $category_id);
            });
        }
        if ($request->product_shortname) {
            $shortname = $request->product_shortname;
            $query = $query->whereHas('product', function ($q) use ($shortname) {
                $q->where('shortname', '=', $shortname);
            });
        }

        if ($request->product_id) {
            $query = $query->where('product_id', '=', $request->product_id);
        }

        if ($request->transaction_status) {
            $query = $query->where('transaction_status', '=', $request->transaction_status);
        }

        if ($request->transaction_reference) {
            $query = $query->where('transaction_reference', '=', $request->transaction_status);
        }

        if ($request->business_reference) {
            $query = $query->where('business_reference', '=', $request->transaction_status);
        }

        if ($request->provider_reference) {
            $query = $query->where('provider_reference', '=', $request->transaction_status);
        }

        if ($request->account_number) {
            $query = $query->where('account_number', '=', $request->account_number);
        }

        if ($request->start_date && $request->end_date) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $query = $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $transactions = $query->take(5)->with('business','product.productCategory', 'product.biller');
        $downloader = new TransactionExport($transactions);
        $date = date('d-m-Y');

        return $downloader->download("VAS-TRANSACTIONS-$date.csv");


        return $this->sendSuccess("Transactions fetched successful", [
            "transactions" => $transactions
        ]);

        // $business->createDemoTransaction(20);
    }
}
