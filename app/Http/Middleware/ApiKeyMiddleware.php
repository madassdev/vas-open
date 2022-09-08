<?php

namespace App\Http\Middleware;

use App\Helpers\DBSwap;
use App\Models\Business;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Find business by apiKey in headers
        DBSwap::setConnection('mysqltest');
        // $apiKey = $request->api_key;
        $apiKey = $request->bearerToken();
        $business = Business::whereTestApiKey($apiKey)->first();
        if (!$business) {

            response()->json([
                "success" => false,
                "message" => "Unauthenticated. Please provide test_api_key"
            ], 401)->throwResponse();
        }

        // Needs extra logic.
        $user = $business->businessUsers()->first();
        auth()->login($user);
        return $next($request);
    }
}
