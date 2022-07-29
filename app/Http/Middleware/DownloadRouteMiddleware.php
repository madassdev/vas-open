<?php

namespace App\Http\Middleware;

use App\Helpers\DBSwap;
use App\Models\Business;
use Closure;
use Illuminate\Http\Request;

class DownloadRouteMiddleware
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
        $auth_context = config('app.auth_context');
        $apiKey = $request->api_key;
        // $apiKey = $request->bearerToken();
        if ($auth_context === "live") {
            $business = Business::whereLiveApiKey($apiKey)->first();
        }
        if ($auth_context === "test") {
            DBSwap::setConnection('mysqltest');
            $business = Business::whereTestApiKey($apiKey)->first();
        }
        if (!$business) {

            response()->json([
                "success" => false,
                "message" => "Unauthenticated. Please provide $auth_context api key"
            ], 401)->throwResponse();
        }

        // Needs extra logic.
        $user = $business->businessUsers()->first();
        auth()->login($user);
        return $next($request);
    }
}
