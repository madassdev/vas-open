<?php

namespace App\Http\Controllers;

use App\Models\Biller;
use Illuminate\Http\Request;

class BillerController extends Controller
{
    //
    public function index()
    {
        $billers = Biller::all();

        return $this->sendSuccess("Billers fetched successfully", [
            "billers" => $billers
        ]);
    }
}
