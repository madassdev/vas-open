<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessController extends Controller
{
    //

    public function switchEnv(Request $request)
    {
        $request->validate([
            "required|string|in:test,live"
        ]);
        // Perform series of checks...
        $business = auth()->user()->business;
        $business->current_env = $request->env;
        $business->save();
        return $this->sendSuccess("Bussiness Env switched to live");
        return 123;
    }
}
