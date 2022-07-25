<?php

namespace App\Http\Controllers;

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

        if ($request->account_number) {
            $query = $query->where('account_number', '=', $request->account_number);
        }

        if ($request->start_date && $request->end_date) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $query = $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $transactions = $query->with('product.productCategory')->paginate($per_page)->appends(request()->query());

        return $transactions;

        // $business->createDemoTransaction(20);
    }
}
