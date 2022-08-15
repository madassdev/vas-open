<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BusinessUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();
        $activeBusiness = $user->active_business;
        $p = $activeBusiness->role->permissions->pluck('name');
        // return $p;

        sr("data", [$p]);
        if (!$activeBusiness->hasPermissionTo($permission)) {
            sr("User does not have the permission: [" . strtoupper($permission) . "]", [], 403);
        }
        // sr();

        return $next($request);
    }
}
