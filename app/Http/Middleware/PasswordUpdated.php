<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PasswordUpdated
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
        if (!auth()->user()->password_changed) {
            return response()->json([
                "message" => "Permision denied! | Please update your password from the default password."
            ], 403);
        }
        return $next($request);
    }
}
