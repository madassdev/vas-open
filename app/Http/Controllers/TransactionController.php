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
            $category_id = $request->category_id;
            $query = $query->whereHas('product', function ($q) use ($category_id) {
                $q->where('product_category_id', '=', $category_id);
            });
        }

        $transactions = $query->paginate($per_page)->appends(request()->query());

        return $transactions;

        // $business->createDemoTransaction(20);
    }
}
