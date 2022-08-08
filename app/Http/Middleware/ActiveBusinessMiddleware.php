<?php

namespace App\Http\Middleware;

use App\Models\BusinessUser;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class ActiveBusinessMiddleware
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
        $user = auth()->user();
        $business = $user->business;
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();

        // Does this user actually still have this business under them?
        if (!$businessUser) {
            return sr('We could not find this business for this user.', [], 403);
        }
        // Is this business the current active business of this user?       
        if (!$businessUser->is_active) {
            return sr('This is not the current active business of this user. Please update active business first.', [], 403);
        }
        return $next($request);
    }
}
