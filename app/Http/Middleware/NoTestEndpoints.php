<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoTestEndpoints
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
        $app_env = config('app.env');
        $request_root = $request->root();
        if ( $app_env !== "production") {
            return response()->json([
                "success" => false,
                "message" => "[ENVIRONMENT ERROR]: Attempting to access LIVE only endpoint.",
                "data" => ["root" => $request_root, "app_env" => $app_env]
            ], 400);
            // abort(403, "[ENVIRONMENT ERROR]: Attempting to access LIVE only endpoint.");
        }
        return $next($request);
    }
}
