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
        $request_root = $request->root();
        $live_domain = env('LIVE_APP_DOMAIN');
        if($request_root !== $live_domain)
        {
            abort(403, "[ENVIRONMENT ERROR]: Attempting to access LIVE only endpoint.");
        }
        return $next($request);
    }
}
