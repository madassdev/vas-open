<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 100;
        $user = auth()->user();
        $query = Transaction::query();
        if ($request->product_category_id) {
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

        if ($request->business_id) {
            $query = $query->where('business_id', '=', $request->business_id);
        }

        if ($request->transaction_status) {
            $query = $query->where('transaction_status', '=', $request->transaction_status);
        }

        if ($request->transaction_reference) {
            $query = $query->where('transaction_reference', '=', $request->transaction_reference);
        }

        if ($request->business_reference) {
            $query = $query->where('business_reference', '=', $request->business_reference);
        }

        if ($request->provider_reference) {
            $query = $query->where('provider_reference', '=', $request->provider_reference);
        }

        if ($request->account_number) {
            $query = $query->where('account_number', '=', $request->account_number);
        }

        if ($request->start_date && $request->end_date) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $query = $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }

        $transactions = $query->with('business', 'product.productCategory', 'product.subProducts', 'product.biller')
            ->orderBy('created_at', 'desc')
            ->paginate($per_page)->appends(request()->query());

        return $this->sendSuccess("Transactions fetched successful", [
            "transactions" => $transactions
        ]);

        // $business->createDemoTransaction(20);
    }

    public function download(Request $request)
    {
        $per_page = $request->per_page ?? 20;
        $user = auth()->user();
        $business = $user->business;
        // $business->createDemoTransaction(rand(30,80));
        $query = Transaction::query();
        if ($request->product_category_id) {
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

        if ($request->business_id) {
            $query = $query->where('business_id', '=', $request->business_id);
        }

        if ($request->transaction_status) {
            $query = $query->where('transaction_status', '=', $request->transaction_status);
        }

        if ($request->transaction_reference) {
            $query = $query->where('transaction_reference', '=', $request->transaction_reference);
        }

        if ($request->business_reference) {
            $query = $query->where('business_reference', '=', $request->business_reference);
        }

        if ($request->provider_reference) {
            $query = $query->where('provider_reference', '=', $request->provider_reference);
        }

        if ($request->account_number) {
            $query = $query->where('account_number', '=', $request->account_number);
        }

        if ($request->start_date && $request->end_date) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $query = $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }

        $transactions = $query->with('business', 'product.productCategory', 'product.subProducts', 'product.biller');
        $downloader = new TransactionExport($transactions);
        $date = date('d-m-Y');

        return $downloader->download("VAS-TRANSACTIONS-$date.csv");


        return $this->sendSuccess("Transactions fetched successful", [
            "transactions" => $transactions
        ]);
        // $business->createDemoTransaction(20);
    }



    public function show($transaction_id)
    {
        $user = auth()->user();
        $transaction = Transaction::whereId($transaction_id)->first();
        if (!$transaction) {
            return $this->sendError("Transaction not found", [], 404);
        }
        $transaction->load('product.productCategory', 'product.subProducts', 'product.biller', 'business', 'extra', 'walletTransactions');
        return $this->sendSuccess("Transaction details retrieved successfully", [
            "transaction" => $transaction
        ]);
    }
}
